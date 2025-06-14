<?php
// app/Http/Controllers/Student/HistoryController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HistoryController extends Controller
{
    /**
     * Tampilkan riwayat sesi student
     */
    public function index(Request $request)
    {
        $query = MentoringSession::forStudent(Auth::id())
                                ->with(['mentor', 'subject']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan mata pelajaran
        if ($request->has('subject_id') && $request->subject_id !== '') {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari !== '') {
            $query->whereDate('date', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai !== '') {
            $query->whereDate('date', '<=', $request->tanggal_sampai);
        }

        // Urutkan berdasarkan tanggal (sesi mendatang di atas, lalu terbaru)
        $sessions = $query->orderByRaw("
                        CASE 
                            WHEN status IN ('confirmed', 'booked') AND date >= CURDATE() THEN 1
                            WHEN status = 'ongoing' THEN 2
                            ELSE 3
                        END
                    ")
                    ->orderBy('date', 'desc')
                    ->orderBy('start_time', 'desc')
                    ->paginate(10);

        // Tambahkan properti computed untuk kemudahan tampilan
        $sessions->getCollection()->transform(function ($session) {
            // Tambahkan informasi waktu tersisa untuk sesi mendatang
            if ($session->is_upcoming) {
                $session->waktu_tersisa = $session->time_remaining;
            }
            return $session;
        });

        // Dapatkan statistik untuk tampilan
        $statistik = $this->hitungStatistikRiwayat(Auth::id());
        
        // Dapatkan semua mata pelajaran untuk dropdown filter
        $mataPelajaran = Subject::orderBy('name')->get();

        return view('student.history.index', compact('sessions', 'statistik', 'mataPelajaran'));
    }

    /**
     * Tampilkan detail sesi tertentu
     */
    public function show(MentoringSession $session)
    {
        // Verifikasi kepemilikan
        if (!$session->isOwnedByStudent(Auth::id())) {
            abort(403, 'Anda hanya dapat melihat sesi Anda sendiri.');
        }

        $session->load(['mentor', 'subject']);

        return view('student.history.show', compact('session'));
    }

    /**
     * Batalkan sesi
     */
    public function cancel(Request $request, MentoringSession $session)
    {
        // Verifikasi kepemilikan
        if (!$session->isOwnedByStudent(Auth::id())) {
            return redirect()->back()
                           ->with('error', 'Anda hanya dapat membatalkan sesi Anda sendiri.');
        }

        // Cek apakah sesi dapat dibatalkan
        if (!$session->can_be_cancelled) {
            return redirect()->back()
                           ->with('error', 'Sesi ini tidak dapat dibatalkan.');
        }

        $validated = $request->validate([
            'alasan_pembatalan' => 'nullable|string|max:500'
        ]);

        try {
            // Gunakan method yang sudah ada di model
            $session->markAsCancelled(
                $validated['alasan_pembatalan'] ?? 'Dibatalkan oleh student', 
                false // jangan hapus student_id untuk history
            );
            
            // Update status ke cancelled (bukan available) untuk tetap menjaga history
            $session->update(['status' => 'cancelled']);
            
            return redirect()->back()
                           ->with('success', 'Sesi berhasil dibatalkan.');
                           
        } catch (\Exception $e) {
            Log::error('Pembatalan sesi gagal: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Gagal membatalkan sesi. Silakan coba lagi.');
        }
    }

    /**
     * Kirim ulasan sesi
     */
    public function review(Request $request, MentoringSession $session)
    {
        // Verifikasi kepemilikan
        if (!$session->isOwnedByStudent(Auth::id())) {
            return redirect()->back()
                           ->with('error', 'Anda hanya dapat mengulas sesi Anda sendiri.');
        }

        // Cek apakah sesi sudah selesai
        if ($session->status !== 'completed') {
            return redirect()->back()
                           ->with('error', 'Anda hanya dapat mengulas sesi yang sudah selesai.');
        }

        // Cek apakah sudah diulas
        if ($session->rating) {
            return redirect()->back()
                           ->with('error', 'Anda sudah memberikan ulasan untuk sesi ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000'
        ]);

        try {
            $session->update([
                'rating' => $validated['rating'],
                'feedback' => $validated['ulasan']
            ]);

            return redirect()->back()
                           ->with('success', 'Terima kasih atas ulasan Anda!');
                           
        } catch (\Exception $e) {
            Log::error('Pengiriman ulasan gagal: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Gagal mengirim ulasan. Silakan coba lagi.');
        }
    }

    /**
     * Hitung statistik riwayat sesi untuk student
     */
    private function hitungStatistikRiwayat($userId)
    {
        $allSessions = MentoringSession::forStudent($userId)->get();
        
        $statistik = [
            'total_sesi' => $allSessions->count(),
            'sesi_selesai' => $allSessions->where('status', 'completed')->count(),
            'sesi_dibatalkan' => $allSessions->where('status', 'cancelled')->count(),
            'total_pengeluaran' => $allSessions->where('status', 'completed')->sum('price'),
            'mata_pelajaran_dipelajari' => $allSessions->where('status', 'completed')
                                                      ->pluck('subject_id')
                                                      ->unique()
                                                      ->count(),
        ];

        // Hitung total jam menggunakan method duration yang sudah ada
        $totalMenit = $allSessions->where('status', 'completed')
                                 ->sum(function ($session) {
                                     return $session->duration;
                                 });
        
        $statistik['total_jam'] = $totalMenit / 60;

        // Hitung rata-rata rating
        $ratedSessions = $allSessions->where('status', 'completed')->whereNotNull('rating');
        $statistik['rata_rating'] = $ratedSessions->count() > 0 ? 
                                   round($ratedSessions->avg('rating'), 1) : 0;

        // Dapatkan mata pelajaran favorit
        $mataPelajaranFavorit = $allSessions->where('status', 'completed')
                                           ->groupBy('subject_id')
                                           ->map(function ($sessions) {
                                               return [
                                                   'count' => $sessions->count(),
                                                   'subject_name' => $sessions->first()->subject->name ?? 'Unknown'
                                               ];
                                           })
                                           ->sortByDesc('count')
                                           ->first();
        
        $statistik['mata_pelajaran_favorit'] = $mataPelajaranFavorit ? 
                                              $mataPelajaranFavorit['subject_name'] : 'Tidak ada';

        return $statistik;
    }

    /**
     * Dapatkan statistik sesi untuk dashboard
     */
    public function getStatistik()
    {
        return $this->hitungStatistikRiwayat(Auth::id());
    }

    /**
     * Dapatkan sesi mendatang untuk widget dashboard
     */
    public function getSesiMendatang($limit = 3)
    {
        return MentoringSession::forStudent(Auth::id())
                              ->whereIn('status', ['confirmed', 'booked'])
                              ->upcoming()
                              ->with(['mentor', 'subject'])
                              ->orderBy('date')
                              ->orderBy('start_time')
                              ->limit($limit)
                              ->get();
    }

    /**
     * Dapatkan sesi yang baru selesai
     */
    public function getSesiBaruSelesai($limit = 5)
    {
        return MentoringSession::forStudent(Auth::id())
                              ->where('status', 'completed')
                              ->with(['mentor', 'subject'])
                              ->orderBy('completed_at', 'desc')
                              ->limit($limit)
                              ->get();
    }

    /**
     * Cek apakah student dapat bergabung ke sesi tertentu
     */
    public function bisaIkutSesi(MentoringSession $session)
    {
        // Verifikasi kepemilikan
        if (!$session->isOwnedByStudent(Auth::id())) {
            return false;
        }

        return $session->can_start;
    }

    /**
     * Dapatkan detail sesi untuk modal/popup
     */
    public function getDetailSesi(MentoringSession $session)
    {
        // Verifikasi kepemilikan
        if (!$session->isOwnedByStudent(Auth::id())) {
            return response()->json(['error' => 'Tidak diizinkan'], 403);
        }

        $session->load(['mentor', 'subject']);

        return response()->json([
            'sesi' => [
                'id' => $session->id,
                'tanggal' => $session->date_formatted,
                'waktu' => $session->time_formatted . ' WIB',
                'durasi' => $session->duration_formatted,
                'mata_pelajaran' => $session->subject->name,
                'mentor' => [
                    'nama' => $session->mentor->name,
                    'foto' => $session->mentor->photo_url ?? null,
                    'rating' => $session->mentor->average_rating ?? 0
                ],
                'harga' => $session->formatted_price,
                'status' => $session->status_text,
                'link_meeting' => $session->meeting_link,
                'bisa_ikut' => $session->can_start,
                'bisa_batal' => $session->can_be_cancelled,
                'catatan' => $session->student_notes,
                'ulasan' => $session->feedback,
                'rating' => $session->rating
            ]
        ]);
    }

    /**
     * Export riwayat sesi ke CSV
     */
    public function export(Request $request)
    {
        $query = MentoringSession::forStudent(Auth::id())
                                ->with(['mentor', 'subject']);

        // Terapkan filter yang sama seperti index
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('subject_id') && $request->subject_id !== '') {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari !== '') {
            $query->whereDate('date', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai !== '') {
            $query->whereDate('date', '<=', $request->tanggal_sampai);
        }

        $sessions = $query->orderBy('date', 'desc')->get();

        $filename = 'riwayat_sesi_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($sessions) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Mata Pelajaran', 'Mentor', 'Status', 'Harga', 'Rating', 'Catatan'
            ]);

            // Data CSV
            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->date ? $session->date->format('d/m/Y') : 'Tidak tersedia',
                    $session->short_time_formatted ?? 'Tidak tersedia',
                    $session->end_time ? $session->end_time->format('H:i') : 'Tidak tersedia',
                    $session->subject->name,
                    $session->mentor->name,
                    $this->getStatusIndonesia($session->status),
                    $session->price ?? 0,
                    $session->rating ?: 'Belum dinilai',
                    $session->student_notes ?: ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Konversi status ke bahasa Indonesia
     */
    private function getStatusIndonesia($status)
    {
        return match($status) {
            'available' => 'Tersedia',
            'booked' => 'Dipesan',
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($status)
        };
    }
}