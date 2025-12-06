<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
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

// ===========================
// LOGIN ROUTES
// ===========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Logout route (accessible when authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ===========================
// ADMIN DASHBOARD ROUTES
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/books-data', [AdminController::class, 'getBooksData'])->name('dashboard.books-data');
    Route::get('/dashboard/members-data', [AdminController::class, 'getMembersData'])->name('dashboard.members-data');
    Route::get('/dashboard/borrowers-data', [AdminController::class, 'getBorrowersData'])->name('dashboard.borrowers-data');
    Route::get('/dashboard/weekly-data', [AdminController::class, 'getWeeklyData'])->name('dashboard.weekly-data');
    Route::get('/dashboard/recent-members', [AdminController::class, 'getRecentMembers'])->name('dashboard.recent-members');

// ===========================
// NOTIFICATION ROUTES
// ===========================
Route::get('/notifications/overdue', function () {
    return view('overdue');
})->name('notifications.overdue');
Route::get('/api/notifications/overdue', [BorrowController::class, 'getOverdueAndDueSoon'])
    ->name('api.notifications.overdue');

// ===========================
// CHATBOT ROUTES
// ===========================
Route::post('/chatbot/message', [ChatbotController::class, 'send']);

// ===========================
// AUDIO ROUTES
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/api/audio/files', [AdminController::class, 'getAudioFiles'])->name('api.audio.files');
});

// ===========================
// BOOKS ROUTES
// ===========================
Route::resource('books', BookController::class);
Route::post('/books/{id}/generate-qr', [BookController::class, 'generateQr'])->name('books.generateQr');
Route::get('/api/media/images', [BookController::class, 'getMediaImages'])->name('api.media.images');
Route::post('/api/media/upload-temp', [BookController::class, 'uploadTempImage'])->name('api.media.upload-temp');
Route::post('/api/media/cleanup-temp', [BookController::class, 'cleanupTempImages'])->name('api.media.cleanup-temp');

// ===========================
// MEMBERS ROUTES
// ===========================
Route::resource('members', MemberController::class);
Route::get('/members/search', [BorrowController::class, 'search']);
Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);
});

// Card JSON endpoint
Route::get('/members/{id}/json', function ($id) {
    $member = Member::find($id);

    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }

    $first  = $member->first_name ?: '';
    $middle = $member->middle_name ?: '';
    $last   = $member->last_name ?: '';

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

// ===========================
// BORROW/TRANSACTION ROUTES
// ===========================
Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.book');
Route::post('/borrow/process', [BorrowController::class, 'borrow'])->name('borrow.process');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
Route::post('/transactions/{id}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
Route::get('/transactions/overdue', [TransactionController::class, 'overdue'])->name('transactions.overdue');

// ===========================
// TIME LOG ROUTES
// ===========================
Route::get('/timelog', [TimeLogController::class, 'index'])->name('timelog.index');
Route::get('/timelog/search', [TimeLogController::class, 'search']);
Route::post('/timelog/time-in', [TimeLogController::class, 'timeIn']);
Route::post('/timelog/time-out', [TimeLogController::class, 'timeOut']);
Route::post('/time-log/scan/{id}', [TimeLogController::class, 'scanQR']);