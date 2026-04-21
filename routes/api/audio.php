<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['web', 'auth', 'restrict.assistant'])->group(function () {
    Route::get('/audio/files', [AdminController::class, 'getAudioFiles'])->name('api.audio.files');
});
