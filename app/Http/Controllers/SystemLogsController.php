<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemLog;

class SystemLogsController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $logs = SystemLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('system-logs.index', compact('logs'));
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
}
