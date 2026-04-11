<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'username' => ['required', 'string', 'min:5', 'max:15', 'regex:/^[A-Za-z][A-Za-z0-9_]{4,14}$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9\s;\'"\/\\\\])[^\s;\'"\/\\\\]{8,20}$/',
            ],
        ], [
            'username.regex' => 'Username must start with a letter and contain only letters, numbers, or underscore.',
            'password.regex' => 'Password must include at least 1 uppercase, 1 lowercase, 1 number, and 1 special character. No spaces or ; \' / \\ allowed.',
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => $validated['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z ]+$/'],
            'username' => ['required', 'string', 'min:5', 'max:15', 'regex:/^[A-Za-z][A-Za-z0-9_]{4,14}$/', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9\s;\'"\/\\\\])[^\s;\'"\/\\\\]{8,20}$/',
            ],
            'age' => ['required', 'integer', 'between:18,60'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'civil_status' => ['required', 'in:Single,Married,Separated,Widowed'],
            'mobile' => ['required', 'regex:/^09\d{9}$/'],
            'address' => ['required', 'string', 'min:50'],
            'zip' => ['required', 'regex:/^\d{4}$/'],
        ], [
            'full_name.regex' => 'Full name must contain letters and spaces only (no dots).',
            'username.regex' => 'Username must start with a letter and contain only letters, numbers, or underscore.',
            'password.regex' => 'Password must include at least 1 uppercase, 1 lowercase, 1 number, and 1 special character. No spaces or ; \' / \\ allowed.',
            'mobile.regex' => 'Mobile number must be 11 digits and start with 09.',
            'zip.regex' => 'ZIP code must be exactly 4 digits.',
        ]);

        $user = User::create([
            'name' => $validated['full_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('product')->with('success', 'Account created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
