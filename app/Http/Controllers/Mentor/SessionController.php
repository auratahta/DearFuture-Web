<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index()
    {
        // Mendapatkan session mentor yang sedang login
        $mentorId = auth()->id();
        
        $sessions = MentoringSession::forMentor($mentorId)
            ->with(['student', 'subject'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);
            
        return view('mentor.sessions.index', compact('sessions'));
    }

    public function show($sessionId)
    {
        $mentorId = auth()->id();
        
        $session = MentoringSession::forMentor($mentorId)
            ->with(['student', 'subject'])
            ->findOrFail($sessionId);
            
        return view('mentor.sessions.show', compact('session'));
    }

    public function cancel($sessionId)
    {
        $mentorId = auth()->id();
        
        try {
            $session = MentoringSession::forMentor($mentorId)->findOrFail($sessionId);
            
            // Validasi apakah session bisa dibatalkan
            if (!$session->can_be_cancelled) {
                return redirect()->back()
                    ->with('error', 'Session tidak dapat dibatalkan. Waktu terlalu dekat atau status tidak memungkinkan.');
            }
            
            // Update status session
            $session->markAsCancelled('Dibatalkan oleh mentor', false); // false = jangan hapus student
            
            return redirect()->back()
                ->with('success', 'Session berhasil dibatalkan.');
                
        } catch (\Exception $e) {
            \Log::error('Error cancelling session: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membatalkan session.');
        }
    }

    public function reschedule(Request $request, $sessionId)
    {
        $mentorId = auth()->id();
        
        // Validasi input
        $validatedData = $request->validate([
            'new_date' => 'required|date|after_or_equal:' . now()->addDay()->format('Y-m-d'),
            'new_start_time' => 'required|date_format:H:i',
            'new_end_time' => 'required|date_format:H:i|after:new_start_time',
            'reschedule_reason' => 'nullable|string|max:500',
        ], [
            'new_date.required' => 'Tanggal baru harus diisi.',
            'new_date.after_or_equal' => 'Tanggal reschedule minimal 1 hari dari sekarang.',
            'new_start_time.required' => 'Waktu mulai harus diisi.',
            'new_start_time.date_format' => 'Format waktu mulai tidak valid (HH:MM).',
            'new_end_time.required' => 'Waktu selesai harus diisi.',
            'new_end_time.date_format' => 'Format waktu selesai tidak valid (HH:MM).',
            'new_end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);
        
        try {
            $session = MentoringSession::forMentor($mentorId)->findOrFail($sessionId);
            
            // Validasi apakah session bisa direschedule
            if (!$session->can_be_rescheduled) {
                return redirect()->back()
                    ->with('error', 'Session tidak dapat dijadwal ulang. Periksa status dan waktu session.');
            }
            
            // Cek apakah mentor sudah ada session di waktu yang sama
            $conflictSession = MentoringSession::forMentor($mentorId)
                ->where('id', '!=', $sessionId)
                ->where('date', $validatedData['new_date'])
                ->where(function($query) use ($validatedData) {
                    $query->whereBetween('start_time', [
                        $validatedData['new_start_time'], 
                        $validatedData['new_end_time']
                    ])
                    ->orWhereBetween('end_time', [
                        $validatedData['new_start_time'], 
                        $validatedData['new_end_time']
                    ])
                    ->orWhere(function($q) use ($validatedData) {
                        $q->where('start_time', '<=', $validatedData['new_start_time'])
                          ->where('end_time', '>=', $validatedData['new_end_time']);
                    });
                })
                ->whereNotIn('status', ['cancelled'])
                ->exists();
                
            if ($conflictSession) {
                return redirect()->back()
                    ->with('error', 'Anda sudah memiliki session lain di waktu yang bertabrakan.');
            }
            
            // Update session dengan data baru
            $session->update([
                'date' => $validatedData['new_date'],
                'start_time' => $validatedData['new_start_time'],
                'end_time' => $validatedData['new_end_time'],
                'reschedule_reason' => $validatedData['reschedule_reason'],
                'status' => 'confirmed', // Kembali ke status confirmed setelah reschedule
            ]);
            
            // Log untuk debugging
            \Log::info('Session rescheduled successfully', [
                'session_id' => $sessionId,
                'mentor_id' => $mentorId,
                'old_date' => $session->getOriginal('date'),
                'new_date' => $validatedData['new_date'],
                'old_start_time' => $session->getOriginal('start_time'),
                'new_start_time' => $validatedData['new_start_time'],
            ]);
            
            return redirect()->back()
                ->with('success', 'Session berhasil dijadwal ulang ke tanggal ' . 
                    Carbon::parse($validatedData['new_date'])->format('d/m/Y') . 
                    ' pukul ' . $validatedData['new_start_time'] . '-' . $validatedData['new_end_time']);
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()
                ->with('error', 'Session tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Error rescheduling session: ' . $e->getMessage(), [
                'session_id' => $sessionId,
                'mentor_id' => $mentorId,
                'request_data' => $validatedData ?? $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menjadwal ulang session. Silakan coba lagi.');
        }
    }
}