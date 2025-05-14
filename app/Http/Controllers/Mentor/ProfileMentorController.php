<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\MentorProfile;

class ProfileMentorController extends Controller
{
    /**
     * Display mentor profile page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Load user with mentorProfile relation to reduce database queries
        $user = Auth::user()->load('mentorProfile');
        
        // Check if the user is a mentor
        if (!$user->isMentor()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        return view('mentor.profile_mentor', compact('user'));
    }

    /**
     * Update mentor profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Check if the user is a mentor
        if (!$user->isMentor()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'experience' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->bio = $request->bio;
        
        // Handle upload foto profile jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
            
            $file = $request->file('photo');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $user->photo = 'photos/' . $filename;
        }
        
        $user->save();

        // Update atau buat data mentor profile
        $mentorProfile = MentorProfile::firstOrNew(['user_id' => $user->id]);
        $mentorProfile->hourly_rate = $request->hourly_rate;
        $mentorProfile->experience = $request->experience;
        $mentorProfile->education = $request->education;
        $mentorProfile->save();

        return redirect()->route('mentor.profile')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Show form for changing password
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        $user = Auth::user();
        
        // Check if the user is a mentor
        if (!$user->isMentor()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        return view('mentor.change-password', compact('user'));
    }

    /**
     * Change mentor password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        // Check if the user is a mentor
        if (!$user->isMentor()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('mentor.profile')->with('success', 'Password berhasil diubah!');
    }
}