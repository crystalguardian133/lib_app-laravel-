<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::middleware(['web', 'auth', 'permission:manage-members'])->group(function () {
    Route::get('/members/demographics', [MemberController::class, 'getDemographicsData'])->name('api.members.demographics');
    Route::get('/members/{memberIdentifier}', [MemberController::class, 'apiShow'])->name('api.members.show');
});
