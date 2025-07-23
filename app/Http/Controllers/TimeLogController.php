<?php 
// app/Http/Controllers/TimeLogController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\TimeLog;
use Carbon\Carbon;

class TimeLogController extends Controller
{
    public function index()
    {
        $logs = TimeLog::with('member')->whereNull('time_out')->get();
        return view('timelog.index', compact('logs'));
    }

   public function search(Request $request)
{
    $query = $request->input('q');

    $members = Member::where('name', 'LIKE', '%' . $query . '%')
        ->select('name')
        ->get();

    return response()->json($members);
}

    public function timeIn(Request $request)
    {
        $name = $request->input('member_name');
        $member = Member::where('name', $name)->first();

        if (!$member) {
            return response()->json(['message' => '❌ Member not found.'], 404);
        }

        $existing = TimeLog::where('member_id', $member->id)->whereNull('time_out')->first();
        if ($existing) {
            return response()->json(['message' => '⚠️ Already timed in.']);
        }

        TimeLog::create([
            'member_id' => $member->id,
            'time_in' => now()
        ]);

        return response()->json(['message' => '✅ Time-in recorded.']);
    }

    public function timeOut(Request $request)
    {
        $id = $request->input('id');
        $log = TimeLog::find($id);

        if (!$log) {
            return response()->json(['message' => '❌ Log not found.'], 404);
        }

        $log->update(['time_out' => now()]);
        return response()->json(['message' => '✅ Time-out recorded.']);
    }
}
