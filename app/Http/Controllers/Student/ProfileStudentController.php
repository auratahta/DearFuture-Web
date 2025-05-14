<?php
// app/Http/Controllers/Student/ProfileStudentController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileStudentController extends Controller
{
    /**
     * Show the student profile.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        return view('student.profile', compact('user'));
    }

    /**
     * Update the student profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'school' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);
        
        $userData = $request->only([
            'name', 'email', 'phone', 'birthdate', 'school', 
            'gender', 'address', 'parent_name', 'parent_phone',
        ]);
        
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            // Generate a descriptive filename
            $fileName = 'user_' . $user->id . '_' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('profile-photos', $fileName, 'public');
            $userData['photo'] = $path;
        }
        
        $user->update($userData);
        
        return redirect()->route('student.profile')
            ->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Show form to change password.
     */
    public function showChangePasswordForm()
    {
        return view('student.change-password');
    }
    
    /**
     * Update the user's password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('student.profile')
            ->with('success', 'Password changed successfully!');
    }
}