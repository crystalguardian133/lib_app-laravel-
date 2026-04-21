<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $expectsJson = $request->expectsJson() || $request->is('api/*');

        if (!$request->user()) {
            if ($expectsJson) {
                return response()->json([
                    'error' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->route('login');
        }

        // Parse roles (comma or pipe separated)
        $roles = preg_split('/[|,]/', $roles);

        // Check if user has any of the required roles
        $hasRole = false;
        foreach ($roles as $role) {
            if ($request->user()->hasRole(trim($role))) {
                $hasRole = true;
                break;
            }
        }

        // If user doesn't have the required role, check if they have admin permission
        if (!$hasRole) {
            // If user has 'admin' permission, grant access regardless of role
            if ($request->user()->hasPermission('admin')) {
                return $next($request);
            }

            // Show toast notification based on the user's role
            if ($request->user()->isAssistant()) {
                $toastMessage = 'Only Librarians and Admins can access this feature.';
            } elseif ($request->user()->isLibrarian()) {
                $toastMessage = 'Only Admins can access this feature.';
            } else {
                $toastMessage = 'You do not have permission to access this feature.';
            }

            if ($expectsJson) {
                return response()->json([
                    'error' => $toastMessage,
                    'required_roles' => array_map('trim', $roles),
                ], 403);
            }

            // Redirect back with toast notification
            return redirect()->back()
                ->with('toast_type', 'error')
                ->with('toast_title', 'Access Denied')
                ->with('toast_message', $toastMessage);
        }

        return $next($request);
    }
}
