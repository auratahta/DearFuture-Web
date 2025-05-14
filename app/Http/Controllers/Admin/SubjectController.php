<?php
// app/Http/Controllers/Admin/SubjectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::orderBy('display_order')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'required|integer|min:1',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'],
            'is_active' => $request->has('is_active'),
        ];

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $fileName = 'subject_' . time() . '.' . $request->file('icon')->extension();
            $request->file('icon')->storeAs('subjects', $fileName, 'public');
            $data['icon'] = $fileName;
        }

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'required|integer|min:1',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'],
            'is_active' => $request->has('is_active'),
        ];

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($subject->icon && Storage::disk('public')->exists('subjects/' . $subject->icon)) {
                Storage::disk('public')->delete('subjects/' . $subject->icon);
            }

            $fileName = 'subject_' . time() . '.' . $request->file('icon')->extension();
            $request->file('icon')->storeAs('subjects', $fileName, 'public');
            $data['icon'] = $fileName;
        }

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Delete icon if exists
        if ($subject->icon && Storage::disk('public')->exists('subjects/' . $subject->icon)) {
            Storage::disk('public')->delete('subjects/' . $subject->icon);
        }

        // Delete related data
        $subject->mentors()->detach();
        
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }

    /**
     * Toggle active status of a subject.
     */
    public function toggleActive(Subject $subject)
    {
        $subject->is_active = !$subject->is_active;
        $subject->save();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject status updated successfully.');
    }

    /**
     * Show the manage mentors page.
     */
    public function manageMentors(Subject $subject)
    {
        $assignedMentors = $subject->mentors;
        $availableMentors = User::where('role', 'mentor')
            ->whereNotIn('id', $assignedMentors->pluck('id')->toArray())
            ->get();

        return view('admin.subjects.mentors', compact('subject', 'assignedMentors', 'availableMentors'));
    }

    /**
     * Add a mentor to the subject.
     */
    public function addMentor(Request $request, Subject $subject)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id',
        ]);

        $mentor = User::findOrFail($request->mentor_id);

        if ($mentor->role !== 'mentor') {
            return redirect()->back()->with('error', 'Selected user is not a mentor.');
        }

        if (!$subject->mentors->contains($mentor->id)) {
            $subject->mentors()->attach($mentor->id);
            return redirect()->back()->with('success', 'Mentor assigned to subject successfully.');
        }

        return redirect()->back()->with('info', 'Mentor already assigned to this subject.');
    }

    /**
     * Remove a mentor from the subject.
     */
    public function removeMentor(Subject $subject, User $mentor)
    {
        $subject->mentors()->detach($mentor->id);

        return redirect()->back()->with('success', 'Mentor removed from subject successfully.');
    }
}