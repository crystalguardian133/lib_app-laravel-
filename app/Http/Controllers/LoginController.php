<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemLog;

class LoginController extends Controller
{
    public function showLogin()
    {
        // Redirect to dashboard if already authenticated
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Log successful login
            $user = Auth::user();
            SystemLog::log(
                'user_login',
                'User logged in successfully',
                $user->id,
                ['login_method' => 'web']
            );

            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        // Log failed login attempt
        SystemLog::log(
            'login_failed',
            'Failed login attempt with username: ' . ($request->username ?? 'unknown'),
            null,
            ['username_attempted' => $request->username]
        );

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log logout before destroying session
        if ($user) {
            SystemLog::log(
                'user_logout',
                'User logged out',
                $user->id,
                ['logout_method' => 'web']
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}