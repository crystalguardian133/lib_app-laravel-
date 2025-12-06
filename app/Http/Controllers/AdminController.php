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

    // Analytics data
    $analytics = $this->getAnalyticsData();

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
        'analytics' => $analytics,
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

private function getAnalyticsData()
{
    // Book popularity by genre
    $bookGenres = DB::table('books')
        ->select('genre', DB::raw('COUNT(*) as count'))
        ->whereNotNull('genre')
        ->groupBy('genre')
        ->orderBy('count', 'desc')
        ->get();

    // Julita barangay distribution with coordinates
    $julitaBarangays = DB::table('members')
        ->select('barangay', DB::raw('COUNT(*) as count'))
        ->where('municipality', 'Julita')
        ->whereNotNull('barangay')
        ->groupBy('barangay')
        ->orderBy('barangay')
        ->get();

    // Add coordinates for each barangay in Julita
    $barangayCoordinates = [
        'Alegria' => [10.9365, 124.9496],
        'Anibong' => [11.0154, 124.9806],
        'Aslum' => [11.0164, 124.9526],
        'Balante' => [10.9369, 124.9444],
        'Bongdo' => [11.0105, 124.9661],
        'Bonifacio' => [10.9688, 124.9572],
        'Bugho' => [10.9467, 124.9418],
        'Calbasag' => [10.9906, 124.9531],
        'Caridad' => [10.9515, 124.9463],
        'Cuya-e' => [10.9861, 124.9646],
        'Dita' => [10.9756, 124.9490],
        'Gitabla' => [10.9968, 124.9607],
        'Hindang' => [10.9974, 124.9730],
        'Inawangan' => [11.0035, 124.9740],
        'Jurao' => [10.9574, 124.9253],
        'Poblacion District I' => [10.9730251,124.9584698],
        'Poblacion District II' => [10.962516,124.9664024],
        'Poblacion District III' => [10.9789252,124.9475884],
        'Poblacion District IV' => [10.974231,124.961458],
        'San Andres' => [10.9580, 124.9358],
        'San Pablo' => [11.0019, 124.9683],
        'Santa Cruz' => [11.0073, 124.9530],
        'Santo Niño' => [10.9278, 124.9580],
        'Tagkip' => [10.9500, 124.9573],
        'Tolosahay' => [10.9403, 124.9627],
        'Villa Hermosa' => [11.0130, 124.9745],
    ];

    // Add coordinates and member details to barangay data
    $julitaBarangaysWithCoords = $julitaBarangays->map(function($barangay) use ($barangayCoordinates) {
        $coords = $barangayCoordinates[$barangay->barangay] ?? [11.0667, 124.5167]; // Default to Julita center

        // Get member details for this barangay
        $members = DB::table('members')
            ->select('first_name', 'middle_name', 'last_name', 'age')
            ->where('municipality', 'Julita')
            ->where('barangay', $barangay->barangay)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function($member) {
                return [
                    'name' => trim($member->first_name . ' ' . ($member->middle_name ? $member->middle_name . ' ' : '') . $member->last_name),
                    'age' => $member->age
                ];
            });

        return [
            'barangay' => $barangay->barangay,
            'count' => $barangay->count,
            'lat' => $coords[0],
            'lng' => $coords[1],
            'members' => $members
        ];
    });

    // Non-Julita municipality distribution
    $otherMunicipalities = DB::table('members')
        ->select('municipality', DB::raw('COUNT(*) as count'))
        ->where('municipality', '!=', 'Julita')
        ->whereNotNull('municipality')
        ->groupBy('municipality')
        ->orderBy('count', 'desc')
        ->get();

    // Age distribution
    $ageDistribution = DB::table('members')
        ->select(
            DB::raw("CASE
                WHEN age BETWEEN 0 AND 12 THEN '0-12'
                WHEN age BETWEEN 13 AND 18 THEN '13-18'
                WHEN age BETWEEN 19 AND 25 THEN '19-25'
                WHEN age BETWEEN 26 AND 35 THEN '26-35'
                WHEN age BETWEEN 36 AND 50 THEN '36-50'
                WHEN age BETWEEN 51 AND 65 THEN '51-65'
                ELSE '65+'
            END as age_group"),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('age_group')
        ->orderByRaw("FIELD(age_group, '0-12', '13-18', '19-25', '26-35', '36-50', '51-65', '65+')")
        ->get();

    // Top 10 most borrowed books
    $topBooks = DB::table('transactions')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->select('books.title', 'books.author', DB::raw('COUNT(*) as borrow_count'))
        ->groupBy('books.id', 'books.title', 'books.author')
        ->orderBy('borrow_count', 'desc')
        ->limit(10)
        ->get();

    // Most active members based on borrowing frequency
    $mostActiveMembers = DB::table('transactions')
        ->join('members', 'transactions.member_id', '=', 'members.id')
        ->select(
            'members.first_name',
            'members.middle_name',
            'members.last_name',
            'members.barangay',
            DB::raw('COUNT(*) as borrow_count'),
            DB::raw('MAX(transactions.created_at) as last_borrow')
        )
        ->groupBy('members.id', 'members.first_name', 'members.middle_name', 'members.last_name', 'members.barangay')
        ->orderBy('borrow_count', 'desc')
        ->limit(10)
        ->get()
        ->map(function($member) {
            return [
                'name' => trim($member->first_name . ' ' . ($member->middle_name ? $member->middle_name . ' ' : '') . $member->last_name),
                'barangay' => $member->barangay,
                'borrow_count' => $member->borrow_count,
                'last_borrow' => $member->last_borrow
            ];
        });

    // Most active members based on time-in/out frequency
    $mostActiveTimeLogMembers = DB::table('time_logs')
        ->join('members', 'time_logs.member_id', '=', 'members.id')
        ->select(
            'members.first_name',
            'members.middle_name',
            'members.last_name',
            'members.barangay',
            DB::raw('COUNT(*) as visit_count'),
            DB::raw('MAX(time_logs.created_at) as last_visit')
        )
        ->groupBy('members.id', 'members.first_name', 'members.middle_name', 'members.last_name', 'members.barangay')
        ->orderBy('visit_count', 'desc')
        ->limit(10)
        ->get()
        ->map(function($member) {
            return [
                'name' => trim($member->first_name . ' ' . ($member->middle_name ? $member->middle_name . ' ' : '') . $member->last_name),
                'barangay' => $member->barangay,
                'visit_count' => $member->visit_count,
                'last_visit' => $member->last_visit
            ];
        });

    return [
        'bookGenres' => $bookGenres,
        'julitaBarangays' => $julitaBarangaysWithCoords,
        'otherMunicipalities' => $otherMunicipalities,
        'ageDistribution' => $ageDistribution,
        'topBooks' => $topBooks,
        'mostActiveMembers' => $mostActiveMembers,
        'mostActiveTimeLogMembers' => $mostActiveTimeLogMembers,
    ];
}

public function getAudioFiles()
{
    $audioPath = public_path('audio');
    $audioFiles = [];

    if (is_dir($audioPath)) {
        $files = scandir($audioPath);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && is_file($audioPath . '/' . $file)) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, ['mp3', 'wav', 'ogg', 'm4a', 'aac'])) {
                    $audioFiles[] = [
                        'filename' => $file,
                        'title' => pathinfo($file, PATHINFO_FILENAME),
                        'url' => asset('audio/' . $file),
                        'size' => filesize($audioPath . '/' . $file)
                    ];
                }
            }
        }
    }

    return response()->json($audioFiles);
}

}
