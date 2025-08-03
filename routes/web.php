<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\TimeLogController;


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
Route::get('/computers',[ComputerController::class, 'index'])->name('computers.index');

//Books Route
Route::get('/books/{isbn}', [BookController::class, 'show']);
Route::put('/books/{isbn}', [BookController::class, 'update']);
Route::resource('books', BookController::class);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::post('/books/{id}/generate-qr', [BookController::class, 'generateQr'])->name('books.generateQr');



//Member routes
Route::get('/api/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

Route::get('/api/members', function () {
    return \App\Models\Member::all();
});

Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
//borrow system routes
Route::post('/borrow', [BorrowController::class, 'borrow'])->name('borrow.book');
Route::get('/suggest-members', [BorrowController::class, 'suggestMembers']);
Route::get('/members/search', [BorrowController::class, 'search']);


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
