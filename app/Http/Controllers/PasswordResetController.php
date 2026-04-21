<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SystemLog;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset email
     */
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email'
        ], [
            'username.required' => 'Please enter your username.'
        ]);

        $user = User::where('username', $request->username)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'The provided username and email do not match any account.'])
                ->withInput($request->only('username', 'email'));
        }

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send verification email
        $verificationUrl = route('password.verify-email', [
            'email' => $user->email,
            'token' => $token
        ]);

        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'verificationUrl' => $verificationUrl
            ], function ($message) use ($user) {
                $message->to($user->email)->subject('Password Reset Request');
            });
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Unable to send verification email right now. Please try again later.'
            ])->withInput($request->only('username', 'email'));
        }

        SystemLog::log(
            'password_reset_requested',
            'Password reset requested for account verification',
            $user->id,
            [
                'username' => $user->username,
                'email' => $user->email,
            ]
        );

        return back()->with('status', 'We have sent you an email with a link to verify your identity and reset your password.');
    }

    /**
     * Show email verification page
     */
    public function showVerifyEmail(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (!$email || !$token) {
            return redirect()->route('password.forgot')->withErrors([
                'email' => 'Invalid verification link. Please request a new one.'
            ]);
        }

        $userExists = User::where('email', $email)->exists();
        if (!$userExists) {
            return redirect()->route('password.forgot')->withErrors([
                'email' => 'Invalid verification link. Please request a new one.'
            ]);
        }

        return view('auth.verify-email', [
            'email' => $email,
            'token' => $token
        ]);
    }

    /**
     * Verify the email and show password reset form
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required'
        ]);

        $email = $request->email;
        $token = $request->token;

        // Check if token exists and is not expired (1 hour expiry)
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('password.forgot')->withErrors(['email' => 'Invalid or expired token. Please request a new reset link.']);
        }

        // Verify the token
        if (!Hash::check($token, $resetRecord->token)) {
            return redirect()->route('password.forgot')->withErrors(['email' => 'Invalid token. Please request a new reset link.']);
        }

        // Check if token is expired (1 hour)
        if (Carbon::parse($resetRecord->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.forgot')->withErrors(['email' => 'Token has expired. Please request a new password reset.']);
        }

        // Token is valid - show reset password form
        return view('auth.reset-password', [
            'email' => $email,
            'token' => $token
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.min' => 'Password must be at least 8 characters long.'
        ]);

        $email = $request->email;
        $token = $request->token;

        // Verify token again
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            return redirect()->route('password.forgot')->withErrors(['email' => 'Invalid reset token. Please request a new reset link.']);
        }

        // Check if token is expired
        if (Carbon::parse($resetRecord->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.forgot')->withErrors(['email' => 'Token has expired. Please request a new reset link.']);
        }

        // Update user password
        $user = User::where('email', $email)->first();
        $user->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        SystemLog::log(
            'password_reset_completed',
            'User password reset was completed successfully',
            $user->id,
            [
                'username' => $user->username,
                'email' => $user->email,
            ]
        );

        // Delete the reset token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect('/login')->with('success', 'Your password has been reset successfully. Please log in with your new password.');
    }
}
