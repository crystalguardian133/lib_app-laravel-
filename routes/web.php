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
use App\Http\Controllers\SystemLogsController;
use App\Http\Controllers\PasswordResetController;

// Redirect root to the dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// ===========================
// LOGIN ROUTES
// ===========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,5')  // Max 5 attempts per 15 minutes
        ->name('login.post');

    // Forgot password flow
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetEmail'])
        ->middleware('throttle:5,5')
        ->name('password.send-reset-email');
    
    // Email verification
    Route::get('/forgot-password/verify-email', [PasswordResetController::class, 'showVerifyEmail'])->name('password.verify-email');
    Route::post('/forgot-password/verify-email', [PasswordResetController::class, 'verifyEmail'])->name('password.verify-email.post');
    
    // Reset password
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
        ->middleware('throttle:5,15')
        ->name('password.reset');
});

// Logout route (accessible when authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Session management routes
Route::middleware('auth')->group(function () {
    Route::get('/sessions', [LoginController::class, 'sessions'])->name('user.sessions');
    Route::post('/sessions/{sessionId}/invalidate', [LoginController::class, 'invalidateSession'])->name('user.sessions.invalidate');
});

// ===========================
// ADMIN DASHBOARD ROUTES
// Admin and Librarian only
// ===========================
Route::middleware(['auth', 'role:librarian,admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/books-data', [AdminController::class, 'getBooksData'])->name('dashboard.books-data');
    Route::get('/dashboard/members-data', [AdminController::class, 'getMembersData'])->name('dashboard.members-data');
    Route::get('/dashboard/borrowers-data', [AdminController::class, 'getBorrowersData'])->name('dashboard.borrowers-data');
    Route::get('/dashboard/weekly-data', [AdminController::class, 'getWeeklyData'])->name('dashboard.weekly-data');
    Route::get('/dashboard/recent-members', [AdminController::class, 'getRecentMembers'])->name('dashboard.recent-members');
});

// ===========================
// NOTIFICATION ROUTES
// Admin and Librarian only
// ===========================
Route::middleware(['auth', 'restrict.assistant'])->group(function () {
    Route::get('/notifications/overdue', function () {
        return view('overdue');
    })->name('notifications.overdue');
});

// ===========================
// CHATBOT ROUTES
// Admin and Librarian only
// ===========================
Route::middleware(['auth', 'restrict.assistant'])->group(function () {
    Route::post('/chatbot/message', [ChatbotController::class, 'send']);
});

// ===========================
// AUDIO ROUTES
// Admin and Librarian only
// ===========================
// ===========================
// BOOKS ROUTES
// Admin and Librarian only
// ===========================
// Dynamic genres for filter (must be declared before books/{book})
Route::middleware(['auth', 'permission:manage-books'])->group(function () {
    Route::get('/books/genres', [BookController::class, 'allGenres'])->name('books.genres');
});

Route::middleware(['auth', 'restrict.assistant', 'permission:manage-books'])->group(function () {
    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::post('/books/{id}/generate-qr', [BookController::class, 'generateQr'])->name('books.generateQr');
});

// Books index/show routes (restricted to users with manage-books permission)
Route::middleware(['auth', 'permission:manage-books'])->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'show']);
});

// ===========================
// MEMBERS ROUTES - BORROW SUPPORT
// Available to all authenticated, non-assistant users
// ===========================
Route::middleware(['auth', 'restrict.assistant'])->group(function () {
    Route::get('/members/search', [BorrowController::class, 'search']);
    Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);
    Route::get('/members/lookup/{id}', [BorrowController::class, 'show']);
});

// ===========================
// MEMBERS ROUTES
// Admin and Librarian only
// ===========================
Route::middleware(['auth', 'permission:manage-members'])->group(function () {
    Route::resource('members', MemberController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'restrict.assistant', 'permission:manage-members'])->group(function () {
    Route::resource('members', MemberController::class)->except(['index', 'show']);
    Route::get('/members/{memberId}/borrowing-history', [MemberController::class, 'getBorrowingHistory'])->name('members.borrowing-history');
    Route::get('/members/{memberId}/timelog-history', [MemberController::class, 'getTimelogHistory'])->name('members.timelog-history');
    Route::post('/members/{memberId}/send-email-code', [MemberController::class, 'sendEmailCode'])
        ->middleware('throttle:3,10')
        ->name('members.send-email-code');
    Route::post('/members/{memberId}/verify-email-code', [MemberController::class, 'verifyEmailCode'])->name('members.verify-email-code');
    Route::post('/members/send-email-code-registration', [MemberController::class, 'sendEmailCodeForRegistration'])
        ->middleware('throttle:3,10')
        ->name('members.send-email-code-registration');
    Route::post('/members/verify-email-code-registration', [MemberController::class, 'verifyEmailCodeForRegistration'])->name('members.verify-email-code-registration');
});

// ===========================
// BORROW/TRANSACTION ROUTES
// Admin and Librarian only
// ===========================
Route::middleware(['auth', 'restrict.assistant'])->group(function () {
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.book');
    Route::post('/borrow/process', [BorrowController::class, 'borrow'])->name('borrow.process');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/borrow-history', [TransactionController::class, 'history'])->name('borrow.history');
    Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
    Route::post('/transactions/{id}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
    Route::get('/transactions/overdue', [TransactionController::class, 'overdue'])->name('transactions.overdue');
});

// ===========================
// TIME LOG ROUTES
// All authenticated users (Admin, Librarian, Assistant)
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/timelog', [TimeLogController::class, 'index'])->name('timelog.index');
    Route::get('/qr-scanner', [TimeLogController::class, 'qrScanner'])->name('timelog.qrScanner');
    Route::get('/timelog/search', [TimeLogController::class, 'search']);
    Route::post('/timelog/time-in', [TimeLogController::class, 'timeIn']);
    Route::post('/timelog/time-out', [TimeLogController::class, 'timeOut']);
    Route::post('/time-log/scan/{id}', [TimeLogController::class, 'scan']);
});

// ===========================
// SYSTEM LOGS ROUTES
// Admin only - protected by auth and permission check in controller
// ===========================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/system-logs', [SystemLogsController::class, 'index'])->name('system-logs.index');
    Route::post('/system-logs/clear', [SystemLogsController::class, 'clear'])->name('system-logs.clear');
});

// ===========================
// ADMIN SETTINGS ROUTES
// Admin and Librarian only (can edit own credentials)
// ===========================
Route::middleware(['auth', 'restrict.assistant'])->group(function () {
    Route::post('/admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update-profile');
    // Current authenticated user force-logout status endpoint for client polling
    Route::get('/auth/force-logout-status', [\App\Http\Controllers\UserManagementController::class, 'checkCurrentForceLogoutStatus'])
        ->middleware('role:admin')
        ->middleware('throttle:12,1')
        ->name('auth.force-logout-status');
});

Route::post('/users/{id}/clear-force-logout', [\App\Http\Controllers\UserManagementController::class, 'clearForceLogoutFlag'])
    ->middleware('auth')
    ->name('users.clear-force-logout');

// ===========================
// USER MANAGEMENT ROUTES
// Admin only - full control over users
// ===========================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [\App\Http\Controllers\UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [\App\Http\Controllers\UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [\App\Http\Controllers\UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    
    // Role change routes (escalation/de-escalation)
    Route::put('/admin/users/{id}/change-role', [\App\Http\Controllers\UserManagementController::class, 'changeRole'])->name('admin.users.change-role');
    
    // Special permission routes
    Route::post('/admin/users/{id}/grant-special-permission', [\App\Http\Controllers\UserManagementController::class, 'grantSpecialPermission'])->name('admin.users.grant-special-permission');
    Route::delete('/admin/users/{id}/revoke-special-permission/{permissionId}', [\App\Http\Controllers\UserManagementController::class, 'revokeSpecialPermission'])->name('admin.users.revoke-special-permission');
    
    // Role permission revocation routes (revoke role-based permissions)
    Route::post('/admin/users/{id}/revoke-role-permission', [\App\Http\Controllers\UserManagementController::class, 'revokeRolePermission'])->name('admin.users.revoke-role-permission');
    Route::post('/admin/users/{id}/restore-permission/{permissionId}', [\App\Http\Controllers\UserManagementController::class, 'restorePermission'])->name('admin.users.restore-permission');
    
    // Force logout route
    Route::post('/admin/users/{id}/force-logout', [\App\Http\Controllers\UserManagementController::class, 'forceLogout'])->name('admin.users.force-logout');

    Route::post('/admin/sessions/{sessionId}/terminate', [\App\Http\Controllers\UserManagementController::class, 'terminateSession'])->name('admin.sessions.terminate');
});

