<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1',
            'number' => 'required|string',
            'school' => 'required|string',
            'birthdate' => 'required|date',
            'parent-name' => 'required|string',
            'parent-phone' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->number,
            'school' => $request->school,
            'birthdate' => $request->birthdate,
            'parent_name' => $request['parent-name'],
            'parent_phone' => $request['parent-phone'],
            'role' => 'pelajar', // Default role
        ]);


        Auth::login($user);
        
        return redirect()->route('student.menu');
    }
}