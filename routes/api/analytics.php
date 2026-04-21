<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['web', 'auth', 'restrict.assistant'])->group(function () {
    Route::get('/analytics/monthly-borrows', [AdminController::class, 'getMonthlyBorrowsApi'])->name('api.analytics.monthly-borrows');
    Route::get('/analytics/most-borrowed-book-trend', [AdminController::class, 'getMonthlyBorrowedBooksApi'])->name('api.analytics.most-borrowed-book-trend');
    Route::get('/analytics/books-comparative', [AdminController::class, 'getMonthlyBooksComparativeApi'])->name('api.analytics.books-comparative');
    Route::get('/analytics/active-areas', [AdminController::class, 'getActiveAreasApi'])->name('api.analytics.active-areas');
    Route::get('/analytics/books-trend', [AdminController::class, 'getBooksTrendApi'])->name('api.analytics.books-trend');
    Route::get('/analytics/book-borrowing-frequency', [AdminController::class, 'getBookBorrowingFrequencyApi'])->name('api.analytics.book-borrowing-frequency');
    Route::get('/analytics/peak-hours', [AdminController::class, 'getPeakHoursApi'])->name('api.analytics.peak-hours');
    Route::get('/analytics/age-activity', [AdminController::class, 'getAgeActivityApi'])->name('api.analytics.age-activity');
});
