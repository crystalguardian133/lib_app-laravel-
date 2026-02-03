<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemLog;

class SystemLogsController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $perPage = $request->get('per_page', 50);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 50;

        $logs = SystemLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('system-logs.index', compact('logs', 'perPage'));
    }

    public function clear()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        SystemLog::truncate();

        return response()->json(['success' => true, 'message' => 'Logs cleared successfully']);
    }

    public function uiTest(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('ui-test');
    }
}
