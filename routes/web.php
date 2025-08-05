<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\TimeLogController;
use App\Models\Member;


// Redirect root to the dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

//Admin dashboard route
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

//Chatbot API route
Route::post('/chatbot/message', [ChatbotController::class, 'send']);

//Dashboard Route
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
//Books Route
Route::get('/books/{isbn}', [BookController::class, 'show']);
Route::put('/books/{isbn}', [BookController::class, 'update']);
Route::resource('books', BookController::class);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::post('/books/{id}/generate-qr', [BookController::class, 'generateQr'])->name('books.generateQr');
Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');


//Member routes
Route::get('/members', [MemberController::class, 'index'])->name('members.index');

// Create or update member
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::post('/members/store-or-update', [MemberController::class, 'storeOrUpdate'])->name('members.store-or-update');

// Show single member (used for edit modal)
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/{id}', [MemberController::class, 'show']);



// Update and delete member
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

// Optional API endpoint (REMOVE this if you want to use controller-based index)
Route::get('/api/members', function () {
    return \App\Models\Member::all();
});

//borrow system routes
Route::post('/borrow', [BorrowController::class, 'borrow'])->name('borrow.book');
Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);
Route::get('/members/search', [BorrowController::class, 'search']);
Route::post('/borrow', [BorrowController::class, 'store']);


Route::get('/members/{id}', function ($id) {
    $member = Member::find($id);

    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }

    $first = $member->first_name ?? '';
    $middle = $member->middle_name ? substr($member->middle_name, 0, 1) . '.' : '';
    $last = $member->last_name ?? '';

    $fullName = trim("{$first} {$middle} {$last}");

    return response()->json([
        'name' => $fullName
    ]);
});

//Logging Routes 

Route::get('/timelog', [TimeLogController::class, 'index']);
Route::get('/timelog/search', [TimeLogController::class, 'search']);
Route::post('/timelog/time-in', [TimeLogController::class, 'timeIn']);
Route::post('/timelog/time-out', [TimeLogController::class, 'timeOut']);
Route::post('/time-log/scan/{id}', [TimeLogController::class, 'scanQR']);


//Transactions Routes

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
Route::post('/transactions/{id}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
