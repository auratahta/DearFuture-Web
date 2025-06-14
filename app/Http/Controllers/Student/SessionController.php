<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MentoringSession;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Display available sessions for booking (main search/browse page)
     * Handles both /student/sessions and /student/find routes
     */
    public function index(Request $request)
    {
        $query = MentoringSession::with(['mentor', 'subject'])
            ->where('status', 'available')
            ->whereNull('student_id')
            ->where('date', '>=', now()->toDateString());

        // Apply filters
        $this->applyFilters($query, $request);

        // Sort
        $this->applySorting($query, $request);

        $sessions = $query->paginate(10);

        // Get all subjects and mentors for filters
        $subjects = $this->getSubjects();
        $mentors = $this->getMentorsWithSessions();

        return view('student.sessions.index', compact('sessions', 'subjects', 'mentors'));
    }

    /**
     * Handle /student/find route - search sessions by subject
     */
    public function find(Request $request)
    {
        // Get the subject parameter
        $subjectId = $request->get('subject');
        
        if ($subjectId) {
            // Validate that subject exists
            try {
                $subject = Subject::findOrFail($subjectId);
                
                // Redirect to index with subject filter
                return redirect()->route('student.sessions.index', [
                    'subject' => $subjectId,
                    'search' => $subject->name
                ])->with('info', "Menampilkan sessions untuk {$subject->name}");
                
            } catch (\Exception $e) {
                // If subject not found, redirect to subjects page
                return redirect()->route('student.sessions.subjects')
                    ->with('error', 'Subject tidak ditemukan.');
            }
        }
        
        // If no subject parameter, redirect to main sessions page
        return redirect()->route('student.sessions.index')
            ->with('info', 'Menampilkan semua sessions yang tersedia.');
    }

    /**
     * Display subjects for session browsing
     */
    public function subjects()
    {
        $subjects = Subject::withCount(['sessions' => function($query) {
            $query->where('status', 'available')
                  ->whereNull('student_id')
                  ->where('date', '>=', now()->toDateString());
        }])
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

        return view('student.subjects', compact('subjects'));
    }

    /**
     * Display sessions for a specific subject
     */
    public function subject(Request $request, Subject $subject)
    {
        $query = MentoringSession::with(['mentor', 'subject'])
            ->where('subject_id', $subject->id)
            ->where('status', 'available')
            ->whereNull('student_id')
            ->where('date', '>=', now()->toDateString());

        // Apply filters from request
        $this->applySubjectFilters($query, $request);

        $sessions = $query->orderBy('date')->orderBy('start_time')->get();

        // Group sessions by date
        $availableSessions = $sessions->groupBy(function($session) {
            return $session->date->format('Y-m-d');
        });

        // Get mentors for this subject
        $mentors = User::whereHas('mentorSessions', function($query) use ($subject) {
            $query->where('subject_id', $subject->id)
                  ->where('status', 'available')
                  ->whereNull('student_id')
                  ->where('date', '>=', now()->toDateString());
        })->distinct()->get();

        return view('student.sessions.subject', compact('subject', 'availableSessions', 'mentors'));
    }

    /**
     * Show specific session details
     */
    public function show(MentoringSession $session)
    {
        // Load relationships
        $session->load(['mentor', 'subject', 'student']);

        // Check if this is student's own session or an available session
        if ($session->student_id && $session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        return view('student.sessions.show', compact('session'));
    }

    /**
     * Show booking page for a session
     */
    public function booking(MentoringSession $session)
    {
        // Check if session is available
        if ($session->status !== 'available' || $session->student_id !== null) {
            return redirect()->route('student.sessions.index')
                           ->with('error', 'This session is no longer available for booking.');
        }

        $session->load(['mentor', 'subject']);
        return view('student.sessions.booking', compact('session'));
    }

    /**
     * Book an available session (NO PAYMENT REQUIRED) - REDIRECT TO SUCCESS PAGE
     */
    public function book(Request $request, MentoringSession $session)
    {
        // Validate that session is available for booking
        if ($session->status !== 'available' || $session->student_id !== null) {
            return redirect()->back()->with('error', 'This session is no longer available for booking.');
        }

        // Check if session date is in the future
        if ($session->date < now()->toDateString()) {
            return redirect()->back()->with('error', 'Cannot book sessions in the past.');
        }

        // Validate input
        $validated = $request->validate([
            'phone' => 'nullable|string|max:15',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            // Book the session directly - NO PAYMENT REQUIRED
            $session->update([
                'student_id' => Auth::id(),
                'status' => 'confirmed', // Direct to confirmed since no payment needed
                'student_notes' => $validated['notes'] ?? null,
            ]);

            // Update user phone if provided
            if (isset($validated['phone']) && $validated['phone']) {
                Auth::user()->update(['phone' => $validated['phone']]);
            }

            // REDIRECT TO SUCCESS PAGE
            return redirect()->route('student.sessions.booking-success', $session->id);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to book session. Please try again.');
        }
    }

    /**
     * Show booking success page
     */
    public function bookingSuccess(MentoringSession $session)
    {
        // Check if user owns this session
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Check if session was recently booked (within last 10 minutes)
        if ($session->updated_at < now()->subMinutes(10)) {
            return redirect()->route('student.history.show', $session->id)
                           ->with('info', 'Redirected to session details.');
        }

        // Load relationships
        $session->load(['mentor', 'subject']);

        return view('student.sessions.booking-success', compact('session'));
    }

    /**
     * Search sessions (for the /student/find route)
     */
    public function search(Request $request)
    {
        return $this->index($request); // Use the same logic as index
    }

    /**
     * Alternative method for browsing sessions (alias for index)
     */
    public function browse(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Cancel a booked session
     */
    public function cancel(Request $request, MentoringSession $session)
    {
        // Check if user owns this session
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Check if session can be cancelled
        if (!in_array($session->status, ['booked', 'confirmed'])) {
            return redirect()->back()->with('error', 'This session cannot be cancelled.');
        }

        // Validate cancellation reason
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        try {
            // Return session to available status for other students to book
            $session->update([
                'status' => 'available',
                'cancelled_at' => now(),
                'cancellation_reason' => $validated['reason'] ?? 'Cancelled by student',
                'student_id' => null, // Remove student assignment
                'student_notes' => null, // Clear student notes
            ]);

            return redirect()->route('student.history.index')
                           ->with('success', 'Session cancelled successfully. The slot is now available for other students.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel session. Please try again.');
        }
    }

    /**
     * Submit feedback/rating for completed session
     */
    public function submitReview(Request $request, MentoringSession $session)
    {
        // Check if user owns this session
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Check if session is completed
        if ($session->status !== 'completed') {
            return redirect()->back()->with('error', 'Can only review completed sessions.');
        }

        // Check if already reviewed
        if ($session->rating) {
            return redirect()->back()->with('error', 'You have already reviewed this session.');
        }

        // Validate feedback
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000'
        ]);

        try {
            $session->update([
                'rating' => $validated['rating'],
                'feedback' => $validated['feedback']
            ]);

            return redirect()->back()->with('success', 'Thank you for your feedback!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit review. Please try again.');
        }
    }

    /**
     * Submit feedback (alias for submitReview)
     */
    public function submitFeedback(Request $request, MentoringSession $session)
    {
        return $this->submitReview($request, $session);
    }

    /**
     * Cancel session (alias for cancel for different route naming)
     */
    public function cancelSession(Request $request, MentoringSession $session)
    {
        return $this->cancel($request, $session);
    }

    /**
     * Request reschedule for a session
     */
    public function requestReschedule(Request $request, MentoringSession $session)
    {
        // Check if user owns this session
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Check if session can be rescheduled
        if (!in_array($session->status, ['booked', 'confirmed'])) {
            return redirect()->back()->with('error', 'This session cannot be rescheduled.');
        }

        // Validate reschedule request
        $validated = $request->validate([
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required',
            'reason' => 'required|string|max:500'
        ]);

        try {
            // Add reschedule request to session notes
            $session->update([
                'reschedule_reason' => $validated['reason'],
                'student_notes' => ($session->student_notes ?? '') . "\n\nReschedule requested for {$validated['preferred_date']} at {$validated['preferred_time']}. Reason: {$validated['reason']}"
            ]);

            return redirect()->back()->with('success', 'Reschedule request submitted. Your mentor will be notified.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit reschedule request. Please try again.');
        }
    }

    /**
     * Join meeting (if meeting link is available)
     */
    public function joinMeeting(MentoringSession $session)
    {
        // Check if user owns this session
        if ($session->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Check if session is ready for meeting
        if (!in_array($session->status, ['confirmed', 'ongoing'])) {
            return redirect()->back()->with('error', 'Meeting is not available yet.');
        }

        // Check if meeting link exists
        if (!$session->meeting_link) {
            return redirect()->back()->with('error', 'Meeting link is not available yet. Please contact your mentor.');
        }

        // Check if it's close to session time (within 15 minutes)
        $sessionDateTime = $session->session_date_time;
        $now = now();
        
        if ($sessionDateTime && $now->lt($sessionDateTime->subMinutes(15))) {
            return redirect()->back()->with('error', 'Meeting will be available 15 minutes before session starts.');
        }

        // Update session status to ongoing if it's time
        if ($sessionDateTime && $now->gte($sessionDateTime) && $session->status === 'confirmed') {
            $session->update(['status' => 'ongoing']);
        }

        // Redirect to meeting link
        return redirect()->away($session->meeting_link);
    }

    /**
     * Book session (alias for book method)
     */
    public function bookSession(Request $request, MentoringSession $session)
    {
        return $this->book($request, $session);
    }

    /**
     * Get available slots for AJAX requests
     */
    public function getAvailableSlots(Request $request)
    {
        $query = MentoringSession::with(['mentor', 'subject'])
            ->where('status', 'available')
            ->whereNull('student_id')
            ->where('date', '>=', now()->toDateString());

        if ($request->has('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('mentor_id')) {
            $query->where('mentor_id', $request->mentor_id);
        }

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        $slots = $query->orderBy('date')->orderBy('start_time')->get();

        return response()->json([
            'success' => true,
            'slots' => $slots->map(function($slot) {
                return [
                    'id' => $slot->id,
                    'date' => $slot->date->format('Y-m-d'),
                    'start_time' => $slot->start_time->format('H:i'),
                    'end_time' => $slot->end_time->format('H:i'),
                    'price' => $slot->price,
                    'mentor' => $slot->mentor->name,
                    'subject' => $slot->subject->name,
                ];
            })
        ]);
    }

    /**
     * Debug method for testing (remove in production)
     */
    public function debug(Request $request)
    {
        if (app()->environment('production')) {
            abort(404);
        }

        $data = [
            'user' => Auth::user(),
            'request_params' => $request->all(),
            'available_sessions' => MentoringSession::with(['mentor', 'subject'])
                ->where('status', 'available')
                ->whereNull('student_id')
                ->where('date', '>=', now()->toDateString())
                ->count(),
            'my_sessions' => MentoringSession::where('student_id', Auth::id())->count(),
        ];

        return response()->json($data);
    }

    // Private helper methods

    private function applyFilters($query, $request)
    {
        // Filter by subject
        if ($request->has('subject') && $request->subject) {
            $query->where('subject_id', $request->subject);
        }
        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by mentor
        if ($request->has('mentor_id') && $request->mentor_id) {
            $query->where('mentor_id', $request->mentor_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('date', '>=', $request->date_from);
        }

        // Filter by price range
        if ($request->has('price_range') && $request->price_range) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) == 2) {
                $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            } elseif ($request->price_range === '150000+') {
                $query->where('price', '>=', 150000);
            }
        }

        // Search by subject name or mentor name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('subject', function($subjectQuery) use ($search) {
                    $subjectQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('mentor', function($mentorQuery) use ($search) {
                    $mentorQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
    }

    private function applySubjectFilters($query, $request)
    {
        if ($request->has('date_from') && $request->date_from) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('time_from') && $request->time_from) {
            $query->whereTime('start_time', '>=', $request->time_from);
        }

        if ($request->has('time_to') && $request->time_to) {
            $query->whereTime('end_time', '<=', $request->time_to);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('mentor_id') && $request->mentor_id) {
            $query->where('mentor_id', $request->mentor_id);
        }
    }

    private function applySorting($query, $request)
    {
        $sortBy = $request->get('sort', 'newest');
        switch($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
                $query->orderBy('date', 'asc')->orderBy('start_time', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    private function getSubjects()
    {
        try {
            return Subject::where('is_active', true)->orderBy('name')->get();
        } catch (\Exception $e) {
            return Subject::orderBy('name')->get();
        }
    }

    private function getMentorsWithSessions()
    {
        try {
            return User::whereHas('mentorSessions', function($query) {
                $query->where('status', 'available')
                      ->whereNull('student_id')
                      ->where('date', '>=', now()->toDateString());
            })->where('role', 'mentor')->where('is_active', true)->distinct()->orderBy('name')->get();
        } catch (\Exception $e) {
            return User::where('role', 'mentor')->orderBy('name')->get();
        }
    }
}