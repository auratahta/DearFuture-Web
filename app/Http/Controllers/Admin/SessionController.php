<?php
// app/Http/Controllers/Admin/SessionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Display a listing of sessions.
     */
    public function index(Request $request)
    {
        $query = MentoringSession::with(['mentor', 'student', 'subject']);
        
        // Filter by type (available slots vs booked sessions)
        if ($request->has('type') && $request->type !== '') {
            if ($request->type === 'available') {
                $query->where('status', 'available')->whereNull('student_id');
            } elseif ($request->type === 'booked') {
                $query->whereNotNull('student_id');
            }
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter by mentor
        if ($request->has('mentor_id') && $request->mentor_id !== '') {
            $query->where('mentor_id', $request->mentor_id);
        }
        
        // Filter by subject
        if ($request->has('subject_id') && $request->subject_id !== '') {
            $query->where('subject_id', $request->subject_id);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mentor', function($mentorQuery) use ($search) {
                    $mentorQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('student', function($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('subject', function($subjectQuery) use ($search) {
                    $subjectQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        $sessions = $query->orderBy('date', 'desc')
                         ->orderBy('start_time', 'desc')
                         ->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_sessions' => MentoringSession::count(),
            'available_slots' => MentoringSession::where('status', 'available')->whereNull('student_id')->count(),
            'booked_sessions' => MentoringSession::whereNotNull('student_id')->count(),
            'confirmed_sessions' => MentoringSession::where('status', 'confirmed')->count(),
            'completed_sessions' => MentoringSession::where('status', 'completed')->count(),
            'today_sessions' => MentoringSession::whereDate('date', today())->count(),
        ];
        
        // Data untuk filter dropdown - menggunakan query yang aman
        $mentors = $this->getMentors();
        $subjects = $this->getSubjects();
        
        return view('admin.sessions.index', compact('sessions', 'mentors', 'subjects', 'stats'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        $mentors = $this->getMentors();
        $subjects = $this->getSubjects();
        
        return view('admin.sessions.create', compact('mentors', 'subjects'));
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'price' => 'required|numeric|min:0',
            'meeting_link' => 'nullable|url',
            'notes' => 'nullable|string|max:1000',
            'repeat_type' => 'nullable|in:none,daily,weekly,monthly',
            'repeat_until' => 'nullable|date|after:date',
            'repeat_count' => 'nullable|integer|min:1|max:52'
        ], [
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
            'end_time.after' => 'End time must be after start time.',
            'date.after_or_equal' => 'Date cannot be in the past.',
            'meeting_link.url' => 'Meeting link must be a valid URL.',
        ]);

        // Check untuk konflik waktu
        $this->checkMentorConflicts(
            $validated['mentor_id'], 
            $validated['date'], 
            $validated['start_time'], 
            $validated['end_time']
        );

        $sessionData = [
            'mentor_id' => $validated['mentor_id'],
            'subject_id' => $validated['subject_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'price' => $validated['price'],
            'status' => 'available',
            'meeting_link' => $validated['meeting_link'] ?? null,
            'notes' => $validated['notes'] ?? null
        ];

        // Handle repetition
        if ($request->repeat_type && $request->repeat_type !== 'none') {
            $created = $this->createRepeatedSessions($sessionData, $request);
            $message = $created > 1 ? "{$created} sessions created successfully." : "Session created successfully.";
        } else {
            MentoringSession::create($sessionData);
            $message = "Session created successfully.";
        }

        return redirect()->route('admin.sessions.index')
                        ->with('success', $message);
    }

    /**
     * Check mentor conflicts
     */
    private function checkMentorConflicts($mentorId, $date, $startTime, $endTime, $excludeSessionId = null)
    {
        $query = MentoringSession::where('mentor_id', $mentorId)
            ->where('date', $date)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            });

        if ($excludeSessionId) {
            $query->where('id', '!=', $excludeSessionId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'time' => 'Mentor already has a session during this time.'
            ]);
        }
    }

    /**
     * Create repeated sessions based on repeat settings
     */
    private function createRepeatedSessions($sessionData, $request)
    {
        $currentDate = Carbon::parse($sessionData['date']);
        $endDate = $request->repeat_until ? Carbon::parse($request->repeat_until) : null;
        $maxSessions = $request->repeat_count ?: 10; // Default max 10 jika tidak ada limit
        $created = 0;

        while ($created < $maxSessions) {
            // Skip if end date is set and current date exceeds it
            if ($endDate && $currentDate->gt($endDate)) {
                break;
            }

            try {
                // Check for conflicts before creating
                $this->checkMentorConflicts(
                    $sessionData['mentor_id'], 
                    $currentDate->format('Y-m-d'), 
                    $sessionData['start_time'], 
                    $sessionData['end_time']
                );
                
                // Create session for this date
                $sessionDataCopy = $sessionData;
                $sessionDataCopy['date'] = $currentDate->format('Y-m-d');
                MentoringSession::create($sessionDataCopy);
                $created++;
            } catch (ValidationException $e) {
                // Skip conflicting dates
            }

            // Move to next occurrence
            switch ($request->repeat_type) {
                case 'daily':
                    $currentDate->addDay();
                    break;
                case 'weekly':
                    $currentDate->addWeek();
                    break;
                case 'monthly':
                    $currentDate->addMonth();
                    break;
            }
        }

        return $created;
    }

    /**
     * Display the specified session.
     */
    public function show(MentoringSession $session)
    {
        $session->load(['mentor', 'student', 'subject']);
        return view('admin.sessions.show', compact('session'));
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit(MentoringSession $session)
    {
        $mentors = $this->getMentors();
        $subjects = $this->getSubjects();
        $students = $this->getStudents();
        
        return view('admin.sessions.edit', compact('session', 'mentors', 'subjects', 'students'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, MentoringSession $session)
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'student_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,pending,confirmed,ongoing,completed,cancelled',
            'meeting_link' => 'nullable|url',
            'notes' => 'nullable|string|max:1000'
        ], [
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
            'end_time.after' => 'End time must be after start time.',
            'meeting_link.url' => 'Meeting link must be a valid URL.',
        ]);

        // Check untuk konflik waktu (exclude current session)
        $this->checkMentorConflicts(
            $validated['mentor_id'], 
            $validated['date'], 
            $validated['start_time'], 
            $validated['end_time'],
            $session->id
        );

        // Handle status logic
        if ($validated['status'] === 'available') {
            $validated['student_id'] = null; // Remove student if status is available
        }

        $session->update($validated);

        return redirect()->route('admin.sessions.show', $session)
                        ->with('success', 'Session updated successfully.');
    }

    /**
     * Update session status only
     */
    public function updateStatus(Request $request, MentoringSession $session)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,booked,pending,confirmed,ongoing,completed,cancelled',
            'cancellation_reason' => 'nullable|string|required_if:status,cancelled'
        ]);

        $oldStatus = $session->status;
        $newStatus = $validated['status'];

        // Handle status-specific logic
        if ($newStatus === 'available') {
            $session->student_id = null; // Remove student assignment
        }

        // Handle cancellation
        if ($newStatus === 'cancelled') {
            $session->status = 'cancelled';
            if (isset($validated['cancellation_reason'])) {
                $session->notes = ($session->notes ? $session->notes . "\n\n" : '') . 
                                "Cancelled: " . $validated['cancellation_reason'];
            }
            $session->save();
        } else {
            $session->update(['status' => $newStatus]);
        }

        $message = "Session status updated from '{$oldStatus}' to '{$newStatus}' successfully.";
        
        return back()->with('success', $message);
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy(MentoringSession $session)
    {
        // Only allow deletion of available sessions or cancelled sessions
        if ($session->student_id && !in_array($session->status, ['cancelled', 'available'])) {
            return redirect()->back()
                           ->with('error', 'Cannot delete a session that has been booked. Cancel it instead.');
        }

        $session->delete();

        return redirect()->route('admin.sessions.index')
                        ->with('success', 'Session deleted successfully.');
    }

    /**
     * Export sessions to CSV
     */
    public function export(Request $request)
    {
        $query = MentoringSession::with(['mentor', 'student', 'subject']);
        
        // Apply same filters as index
        if ($request->has('type') && $request->type !== '') {
            if ($request->type === 'available') {
                $query->where('status', 'available')->whereNull('student_id');
            } elseif ($request->type === 'booked') {
                $query->whereNotNull('student_id');
            }
        }
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mentor', function($mentorQuery) use ($search) {
                    $mentorQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('student', function($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('subject', function($subjectQuery) use ($search) {
                    $subjectQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        $sessions = $query->orderBy('date')->orderBy('start_time')->get();
        
        $filename = 'sessions_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($sessions) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Date', 'Start Time', 'End Time', 'Mentor', 'Student', 
                'Subject', 'Status', 'Price', 'Meeting Link', 'Notes', 'Created At'
            ]);
            
            // CSV Data
            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->id,
                    $session->date ? $session->date->format('Y-m-d') : 'N/A',
                    $session->start_time ?: 'N/A',
                    $session->end_time ?: 'N/A',
                    $session->mentor->name ?? 'N/A',
                    $session->student ? $session->student->name : 'N/A',
                    $session->subject->name ?? 'N/A',
                    $session->status,
                    $session->price,
                    $session->meeting_link ?: 'N/A',
                    $session->notes ?: 'N/A',
                    $session->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get mentors safely - adapt based on your user table structure
     */
    private function getMentors()
    {
        // Cek kolom apa saja yang ada di table users
        try {
            // Jika ada kolom role dan status
            return User::where('role', 'mentor')->where('status', 'active')->get();
        } catch (\Exception $e) {
            try {
                // Jika hanya ada kolom role
                return User::where('role', 'mentor')->get();
            } catch (\Exception $e2) {
                try {
                    // Jika ada kolom is_mentor atau similar
                    return User::where('is_mentor', true)->get();
                } catch (\Exception $e3) {
                    // Fallback: ambil semua user
                    return User::all();
                }
            }
        }
    }

    /**
     * Get students safely - adapt based on your user table structure
     */
    private function getStudents()
    {
        try {
            // Jika ada kolom role dan status
            return User::where('role', 'student')->where('status', 'active')->get();
        } catch (\Exception $e) {
            try {
                // Jika hanya ada kolom role
                return User::where('role', 'student')->get();
            } catch (\Exception $e2) {
                try {
                    // Jika ada kolom is_student atau similar
                    return User::where('is_student', true)->get();
                } catch (\Exception $e3) {
                    // Fallback: ambil semua user
                    return User::all();
                }
            }
        }
    }

    /**
     * Get subjects safely - adapt based on your subject table structure
     */
    private function getSubjects()
    {
        try {
            // Jika ada kolom status
            return Subject::where('status', 'active')->orderBy('name')->get();
        } catch (\Exception $e) {
            try {
                // Jika ada kolom is_active
                return Subject::where('is_active', true)->orderBy('name')->get();
            } catch (\Exception $e2) {
                // Fallback: ambil semua subject
                return Subject::orderBy('name')->get();
            }
        }
    }
}