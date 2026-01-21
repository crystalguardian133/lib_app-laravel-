<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SystemLogsController;
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
// ANALYTICS ROUTES
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/api/analytics/monthly-borrows', [AdminController::class, 'getMonthlyBorrowsApi'])->name('api.analytics.monthly-borrows');
    Route::get('/api/analytics/active-areas', [AdminController::class, 'getActiveAreasApi'])->name('api.analytics.active-areas');
    Route::get('/api/analytics/books-trend', [AdminController::class, 'getBooksTrendApi'])->name('api.analytics.books-trend');
    Route::get('/api/analytics/book-borrowing-frequency', [AdminController::class, 'getBookBorrowingFrequencyApi'])->name('api.analytics.book-borrowing-frequency');
    Route::get('/api/analytics/peak-hours', [AdminController::class, 'getPeakHoursApi'])->name('api.analytics.peak-hours');
    Route::get('/api/analytics/age-activity', [AdminController::class, 'getAgeActivityApi'])->name('api.analytics.age-activity');
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
Route::get('/members/{memberId}/borrowing-history', [MemberController::class, 'getBorrowingHistory'])->name('members.borrowing-history');
Route::get('/members/{memberId}/timelog-history', [MemberController::class, 'getTimelogHistory'])->name('members.timelog-history');
Route::post('/members/{memberId}/send-email-code', [MemberController::class, 'sendEmailCode'])->name('members.send-email-code');
Route::post('/members/{memberId}/verify-email-code', [MemberController::class, 'verifyEmailCode'])->name('members.verify-email-code');
Route::post('/members/send-email-code-registration', [MemberController::class, 'sendEmailCodeForRegistration'])->name('members.send-email-code-registration');
Route::post('/members/verify-email-code-registration', [MemberController::class, 'verifyEmailCodeForRegistration'])->name('members.verify-email-code-registration');
Route::get('/members/search', [BorrowController::class, 'search']);
Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);

// API Routes for Dashboard
Route::middleware('auth')->group(function () {
    // Demographics route moved to api.php
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
        'contactNumber' => $member->contactnumber ?? '',
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
Route::get('/qr-scanner', [TimeLogController::class, 'qrScanner'])->name('qr-scanner');
Route::get('/timelog/search', [TimeLogController::class, 'search']);
Route::post('/timelog/time-in', [TimeLogController::class, 'timeIn']);
Route::post('/timelog/time-out', [TimeLogController::class, 'timeOut']);
Route::post('/time-log/scan/{id}', [TimeLogController::class, 'scanQR']);

// ===========================
// SYSTEM LOGS ROUTES
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/system-logs', [SystemLogsController::class, 'index'])->name('system-logs.index');
    Route::post('/system-logs/clear', [SystemLogsController::class, 'clear'])->name('system-logs.clear');
});

// ===========================
// ADMIN SETTINGS ROUTES
// ===========================
Route::middleware('auth')->group(function () {
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password');
});
});
