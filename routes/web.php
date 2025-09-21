<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\CardController;
use App\Models\Member;

// Redirect root to the dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Admin dashboard route
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/books-data', [AdminController::class, 'getBooksData'])->name('dashboard.books-data');
Route::get('/dashboard/members-data', [AdminController::class, 'getMembersData'])->name('dashboard.members-data');
Route::get('/dashboard/borrowers-data', [AdminController::class, 'getBorrowersData'])->name('dashboard.borrowers-data');
Route::get('/dashboard/weekly-data', [AdminController::class, 'getWeeklyData'])->name('dashboard.weekly-data');
Route::get('/dashboard/recent-members', [AdminController::class, 'getRecentMembers'])->name('dashboard.recent-members');

//TEST
Route::get('/notifications/overdue', function () {
    return view('overdue');
})->name('notifications.overdue');

// Chatbot API route
Route::post('/chatbot/message', [ChatbotController::class, 'send']);

// Dashboard Route
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/timelog', [TimeLogController::class, 'index'])->name('timelog.index');

// Books Route
Route::resource('books', BookController::class);
Route::post('/books/{id}/generate-qr', [BookController::class, 'generateQr'])->name('books.generateQr');

// Overdue Routes
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::get('/api/notifications/overdue', [BorrowController::class, 'getOverdueAndDueSoon'])
    ->name('api.notifications.overdue');


// Member routes
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);
Route::resource('members', MemberController::class);

// Borrow system routes
Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.book');
Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);
Route::get('/members/search', [BorrowController::class, 'search']);
Route::get('/members/{id}', [MemberController::class, 'show']);


// Logging Routes
Route::get('/timelog/search', [TimeLogController::class, 'search']);
Route::post('/timelog/time-in', [TimeLogController::class, 'timeIn']);
Route::post('/timelog/time-out', [TimeLogController::class, 'timeOut']);
Route::post('/time-log/scan/{id}', [TimeLogController::class, 'scanQR']);

// Transactions Routes
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
Route::post('/transactions/{id}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
Route::get('/transactions/overdue', [TransactionController::class, 'overdue'])->name('transactions.overdue');

//Card Generation Routess
Route::get('/members/{id}/json', function ($id) {
    $member = Member::find($id);

    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }

    // Handle null gracefully
    $first  = $member->first_name ?: '';
    $middle = $member->middle_name ?: '';
    $last   = $member->last_name ?: '';

    // Build formatted full name (skip nulls/blanks)
    $middleInitial = $middle ? strtoupper(substr($middle, 0, 1)) . '.' : '';
    $fullName = trim(preg_replace('/\s+/', ' ', "{$last}, {$first} {$middleInitial}"));

    return response()->json([
        'id'         => $member->id,
        'firstName'  => $first,
        'middleName' => $middle,
        'lastName'   => $last,
        'fullName'   => $fullName ?: '',
        'age'        => $member->age ?? '',
        'barangay'   => $member->barangay ?? '',
        'municipality' => $member->municipality ?? '',
        'province'   => $member->province ?? '',
        'contactNumber' => $member->contact_number ?? '',
        'memberdate' => $member->memberdate 
                        ? \Carbon\Carbon::parse($member->memberdate)->format('Y-m-d') 
                        : '',
        'photo'      => $member->photo 
                        ? URL::to('/resource/member_images/' . $member->photo) 
                        : '',
        'qr'         => URL::to('/qrcode/members/member-' . $member->id . '.png'),
    ]);
});


