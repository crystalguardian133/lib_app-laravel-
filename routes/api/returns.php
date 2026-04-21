<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::middleware(['web', 'auth', 'permission:return-books|manage-books'])->group(function () {
    Route::post('/returns/bulk', [TransactionController::class, 'bulkReturn'])->name('api.returns.bulk');
});
