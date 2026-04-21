<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemFeatureController;

Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    Route::get('/system/features', [SystemFeatureController::class, 'index'])->name('api.system.features.index');
    Route::get('/system/features/{feature}', [SystemFeatureController::class, 'show'])->name('api.system.features.show');
});
