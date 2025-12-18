<?php

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
        $historyLogs = TimeLog::with('member')
            ->whereNotNull('time_out')
            ->orderBy('time_out', 'desc')
            ->take(50)
            ->get();
        return view('timelog.index', compact('logs', 'historyLogs'));
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

    public function scan(Request $request, $id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found.'], 404);
        }

        $log = TimeLog::where('member_id', $member->id)
                    ->whereNull('time_out')
                    ->latest()
                    ->first();

        if ($log) {
            // Time out
            $log->update(['time_out' => now()]);
            return response()->json(['message' => '✅ Time-Out successful for ' . $member->name]);
        } else {
            // Time in
            TimeLog::create([
                'member_id' => $member->id,
                'time_in' => now()
            ]);
            return response()->json(['message' => '✅ Time-In successful for ' . $member->name]);
        }
    }

    public function scanQR($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        if ($this->isMemberTimedIn($member->id)) {
            $this->logoutMember($member->id);
            return response()->json(['message' => '👋 Time-out successful!']);
        } else {
            $this->logTimeIn($member->id);
            return response()->json(['message' => '✅ Time-in successful!']);
        }
    }

    // ✅ Helper: check if member is timed in
    private function isMemberTimedIn($memberId)
    {
        return TimeLog::where('member_id', $memberId)->whereNull('time_out')->exists();
    }

    // ✅ Helper: time in
    private function logTimeIn($memberId)
    {
        TimeLog::create([
            'member_id' => $memberId,
            'time_in' => now(),
        ]);
    }

    // ✅ Helper: time out
    private function logoutMember($memberId)
    {
        $log = TimeLog::where('member_id', $memberId)
                      ->whereNull('time_out')
                      ->latest()
                      ->first();

        if ($log) {
            $log->update(['time_out' => now()]);
        }
    }
}
