<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemLog;
use App\Models\LoginSession;

class LoginController extends Controller
{
    public function showLogin()
    {
        // Redirect to dashboard if already authenticated
        if (Auth::check()) {
            return $this->redirectToAppropriatePage();
        }

        return view('login.login');
    }

    public function login(Request $request)
    {
        // Validate input to prevent malformed attacks
        $validated = $request->validate([
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9._-]+$/',
            'password' => 'required|string|max:255',
            'remember' => 'nullable|boolean',
        ], [
            'username.regex' => 'Username contains invalid characters.',
            'username.max' => 'Username must not exceed 255 characters.',
            'password.max' => 'Password must not exceed 255 characters.',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Check if user already has an active session
            $existingSession = LoginSession::where('user_id', $user->id)
                ->where('is_active', true)
                ->where('expires_at', '>', now())
                ->first();

            if ($existingSession) {
                // User is already logged in elsewhere - log them out and show error
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Log the blocked login attempt
                SystemLog::log(
                    'login_blocked',
                    'Login blocked - user already logged in elsewhere',
                    $user->id,
                    [
                        'reason' => 'existing_session',
                        'existing_session_id' => $existingSession->id,
                        'ip_address' => $request->ip(),
                    ]
                );

                return back()->withErrors([
                    'username' => 'This account is already logged in on another device. Please log out from that device first or contact an admin.',
                ])->onlyInput('username');
            }

            $request->session()->regenerate();

            // Invalidate all other sessions for this user (single session per user)
            LoginSession::invalidateAllForUser($user->id);

            // Clear force_logout flag on successful login
            $user->forceFill(['force_logout' => false])->save();

            // Create new session record
            $loginSession = LoginSession::createForUser($user, $request);

            // Log successful login
            SystemLog::log(
                'user_login',
                'User logged in successfully',
                $user->id,
                [
                    'login_method' => 'web',
                    'session_id' => $loginSession->id,
                    'ip_address' => $request->ip(),
                ]
            );

            return redirect()->intended($this->redirectToAppropriatePage())->with('success', 'Welcome back!');
        }

        // Log failed login attempt (without exposing username for security)
        SystemLog::log(
            'login_failed',
            'Failed login attempt',
            null,
            [
                'ip_address' => $request->ip(),
                'attempted_at' => now(),
                // Hash the username so logs don't reveal valid usernames
                'username_hash' => hash('sha256', strtolower($request->username ?? ''))
            ]
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
            // Invalidate the current session
            LoginSession::where('session_id', session()->getId())->update(['is_active' => false]);

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

    /**
     * Get active sessions for the current user.
     */
    public function sessions(Request $request)
    {
        // Explicitly validate and cast the 'all' parameter to boolean
        $viewingAll = filter_var($request->get('all', false), FILTER_VALIDATE_BOOLEAN);
        
        $user = Auth::user();
        
        // Only admins can view all sessions - explicit authorization check
        if ($viewingAll && !$user->isAdmin()) {
            return back()->with('error', 'You do not have permission to view all sessions.');
        }
        
        if ($viewingAll && $user->isAdmin()) {
            $sessions = LoginSession::getAllActiveSessions()->get();
        } else {
            $sessions = LoginSession::getActiveSessionsForUser($user->id)->get();
            $viewingAll = false;
        }

        return view('login.sessions', compact('sessions', 'user', 'viewingAll'));
    }

    /**
     * Invalidate a specific session.
     */
    public function invalidateSession(Request $request, $sessionId)
    {
        // Validate that sessionId is a valid integer
        if (!is_numeric($sessionId) || $sessionId <= 0) {
            return back()->with('error', 'Invalid session ID.');
        }

        $user = Auth::user();
        $session = LoginSession::findOrFail($sessionId);
        
        // Authorization check: User can only invalidate their own sessions (unless admin)
        if (!$user->isAdmin() && $session->user_id !== $user->id) {
            // Don't reveal whether session exists - consistent response
            return back()->with('error', 'Unauthorized action.');
        }

        $session->invalidate();

        SystemLog::log(
            'user_session_terminated',
            'User terminated a login session' . ($user->isAdmin() ? ' (admin action)' : ''),
            $user->id,
            [
                'terminated_session_id' => $sessionId,
                'target_user_id' => $session->user_id,
                'is_admin_action' => $user->isAdmin()
            ]
        );

        return back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Redirect user to appropriate page based on their role.
     */
    protected function redirectToAppropriatePage(): string
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            return '/dashboard';
        }

        // Assistants should be redirected to timelog page
        if ($user->isAssistant()) {
            return '/timelog';
        }

        // Admin and Librarian go to dashboard
        return '/dashboard';
    }
}
