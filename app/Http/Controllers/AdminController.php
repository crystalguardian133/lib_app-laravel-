<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrower;
use App\Models\Transaction;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
{
    $booksCount = Book::count();
    $membersCount = DB::table('members')->count();
    $transactionsCount = Transaction::count();

    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    $dailyCount = Transaction::whereDate('created_at', $today)->count();
    $weeklyCount = Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    $lifetimeCount = $transactionsCount;

    // Books added
    $booksToday = Book::whereDate('created_at', $today)->count();
    $booksThisWeek = Book::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

    // Members registered
    $membersToday = DB::table('members')->whereDate('created_at', $today)->count();
    $membersThisWeek = DB::table('members')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

    // Transactions per last 7 days
    $last7Days = collect();
    foreach (range(6, 0) as $i) {
        $date = Carbon::today()->subDays($i)->toDateString();
        $count = Transaction::whereDate('created_at', $date)->count();
        $last7Days->push(['date' => $date, 'count' => $count]);
    }

    // Visits per last 7 days (from timelogs)
    $visitsData = collect();
    foreach (range(6, 0) as $i) {
        $date = Carbon::today()->subDays($i)->toDateString();
        $count = \App\Models\TimeLog::whereDate('created_at', $date)->count();
        $visitsData->push(['date' => $date, 'count' => $count]);
    }

    return view('dashboard', [
        'booksCount' => $booksCount,
        'membersCount' => $membersCount,
        'transactionsCount' => $transactionsCount,
        'dailyCount' => $dailyCount,
        'weeklyCount' => $weeklyCount,
        'lifetimeCount' => $lifetimeCount,
        'booksToday' => $booksToday,
        'booksThisWeek' => $booksThisWeek,
        'membersToday' => $membersToday,
        'membersThisWeek' => $membersThisWeek,
        'last7Days' => $last7Days,
        'visitsData' => $visitsData,
    ]);
}

}
