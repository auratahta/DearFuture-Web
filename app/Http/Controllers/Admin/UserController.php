<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MentorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $role = $request->input('role', 'all');
        
        if ($role !== 'all') {
            $users = User::where('role', $role)
                    ->latest()
                    ->paginate(10);
        } else {
            $users = User::latest()
                    ->paginate(10);
        }
        
        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pelajar,mentor',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        // Create mentor profile if user is a mentor
        if ($user->role === 'mentor') {
            MentorProfile::create([
                'user_id' => $user->id,
                'experience' => $request->experience ?? '',
                'education' => $request->education ?? '',
                'hourly_rate' => $request->hourly_rate ?? 0,
                'is_active' => $request->has('is_active'),
            ]);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,pelajar,mentor',
            'password' => 'nullable|min:8',
        ]);
        
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        $user->update($userData);
        
        // Handle mentor profile if user is a mentor
        if ($user->role === 'mentor') {
            $mentorProfile = MentorProfile::where('user_id', $user->id)->first();
            
            if (!$mentorProfile) {
                MentorProfile::create([
                    'user_id' => $user->id,
                    'experience' => $request->experience ?? '',
                    'education' => $request->education ?? '',
                    'hourly_rate' => $request->hourly_rate ?? 0,
                    'is_active' => $request->has('is_active'),
                ]);
            } else {
                $mentorProfile->update([
                    'experience' => $request->experience,
                    'education' => $request->education,
                    'hourly_rate' => $request->hourly_rate,
                    'is_active' => $request->has('is_active'),
                ]);
            }
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Delete mentor profile if exists
        if ($user->role === 'mentor') {
            $mentorProfile = MentorProfile::where('user_id', $user->id)->first();
            if ($mentorProfile) {
                $mentorProfile->delete();
            }
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}