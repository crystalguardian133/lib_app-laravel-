<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowController;

Route::middleware(['web', 'auth', 'restrict.assistant'])->group(function () {
    Route::get('/notifications/overdue', [BorrowController::class, 'getOverdueAndDueSoon'])->name('api.notifications.overdue');
    Route::post('/notifications/overdue/semi-auto-mailer', [BorrowController::class, 'sendSemiAutoOverdueMailer'])->name('api.notifications.overdue.semi-auto-mailer');
});
