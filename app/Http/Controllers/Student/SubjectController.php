<?php
// app/Http/Controllers/Student/SubjectController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of all active subjects.
     */
    public function index()
    {
        // Ambil semua mata pelajaran yang aktif dan urutkan berdasarkan display_order
        $subjects = Subject::where('is_active', true)
                           ->orderBy('display_order')
                           ->get();
                           
        return view('student.subjects', compact('subjects'));
    }
    
    /**
     * View detail subject untuk student
     */
    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        
        if (!$subject->is_active) {
            return redirect()->route('student.subjects')
                             ->with('error', 'Mata pelajaran tidak tersedia.');
        }
        
        // Ambil mentor yang mengajar subject ini
        $mentors = $subject->mentors;
        
        return view('student.subject_detail', compact('subject', 'mentors'));
    }
    
    /**
     * Find mentors for a specific subject
     */
    public function findMentors(Request $request)
    {
        $subjectId = $request->input('subject');
        
        if (!$subjectId) {
            return redirect()->route('student.subjects');
        }
        
        $subject = Subject::findOrFail($subjectId);
        
        if (!$subject->is_active) {
            return redirect()->route('student.subjects')
                             ->with('error', 'Mata pelajaran tidak tersedia.');
        }
        
        // Ambil mentor yang mengajar subject ini
        $mentors = $subject->mentors;
        
        return view('student.find_mentors', compact('subject', 'mentors'));
    }
}