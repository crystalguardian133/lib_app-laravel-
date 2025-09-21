<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrower;
use App\Models\Transaction;
use App\Models\TimeLog;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
{
    $booksCount = Book::count();
    $membersCount = DB::table('members')->count();

    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    $dailyCount = Transaction::whereDate('created_at', $today)->count();
    $weeklyCount = Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    $lifetimeCount = Transaction::count();

    // Books added
    $booksToday = Book::whereDate('created_at', $today)->count();
    $booksThisWeek = Book::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

    // Members registered
    $membersToday = DB::table('members')->whereDate('created_at', $today)->count();
    $membersThisWeek = DB::table('members')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    
    // Additional member statistics
    $julitaMembers = DB::table('members')->where('municipality', 'Julita')->count();
    $activeMembers = DB::table('members')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('transactions')
                  ->whereColumn('transactions.member_id', 'members.id')
                  ->whereNull('transactions.returned_at');
        })
        ->count();

    // Weekly data for the last 4 weeks
    $weeklyData = collect();
    foreach (range(3, 0) as $i) {
        $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
        $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
        $count = Transaction::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $weekLabel = $weekStart->format('M d') . ' - ' . $weekEnd->format('M d');
        $weeklyData->push(['week' => $weekLabel, 'count' => $count]);
    }

    // Visits per last 7 days (from timelogs)
    $visitsData = collect();
    foreach (range(6, 0) as $i) {
        $date = Carbon::today()->subDays($i)->toDateString();
        $count = \App\Models\TimeLog::whereDate('created_at', $date)->count();
        $visitsData->push(['date' => $date, 'count' => $count]);
    }

    // Get all borrowers with their book and member information
    $borrowers = Transaction::with(['book', 'member'])
        ->orderBy('borrowed_at', 'desc')
        ->get();

    return view('dashboard', [
        'booksCount' => $booksCount,
        'membersCount' => $membersCount,
        'dailyCount' => $dailyCount,
        'weeklyCount' => $weeklyCount,
        'lifetimeCount' => $lifetimeCount,
        'booksToday' => $booksToday,
        'booksThisWeek' => $booksThisWeek,
        'membersToday' => $membersToday,
        'membersThisWeek' => $membersThisWeek,
        'julitaMembers' => $julitaMembers,
        'activeMembers' => $activeMembers,
        'weeklyData' => $weeklyData,
        'visitsData' => $visitsData,
        'borrowers' => $borrowers,
    ]);
}

public function getBooksData()
{
    $books = Book::select('id', 'title', 'author', 'genre', 'published_year', 'availability', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($books);
}

public function getMembersData()
{
    $members = Member::select('id', 'first_name', 'middle_name', 'last_name', 'age', 'barangay', 'contactnumber', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($members);
}

public function getBorrowersData(Request $request)
{
    $filter = $request->get('filter', 'all'); // all, today, weekly
    
    $query = Transaction::with(['book', 'member']);
    
    if ($filter === 'today') {
        $query->whereDate('borrowed_at', Carbon::today());
    } elseif ($filter === 'weekly') {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $query->whereBetween('borrowed_at', [$startOfWeek, $endOfWeek]);
    }
    
    $borrowers = $query->orderBy('borrowed_at', 'desc')->get();
    
    return response()->json($borrowers);
}

public function getWeeklyData(Request $request)
{
    $month = $request->get('month', Carbon::now()->month);
    $year = $request->get('year', Carbon::now()->year);
    
    $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
    $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
    
    $weeklyData = collect();
    $currentWeek = $startOfMonth->copy()->startOfWeek();
    
    while ($currentWeek->lte($endOfMonth)) {
        $weekEnd = $currentWeek->copy()->endOfWeek();
        if ($weekEnd->gt($endOfMonth)) {
            $weekEnd = $endOfMonth;
        }
        
        $count = Transaction::whereBetween('borrowed_at', [$currentWeek, $weekEnd])->count();
        $weekLabel = $currentWeek->format('M d') . ' - ' . $weekEnd->format('M d');
        $weeklyData->push(['week' => $weekLabel, 'count' => $count]);
        
        $currentWeek->addWeek();
    }
    
    return response()->json($weeklyData);
}

public function getRecentMembers()
{
    $members = Member::select('id', 'first_name', 'middle_name', 'last_name', 'barangay', 'created_at')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return response()->json($members);
}

}
