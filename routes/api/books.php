<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\BookController;

Route::middleware(['web', 'auth', 'permission:manage-books'])->group(function () {
    Route::get('/books/genres', [BookController::class, 'allGenres'])->name('api.books.genres');

    Route::get('/books/{bookIdentifier}', function ($bookIdentifier) {
        $book = Book::where('uuid', $bookIdentifier)
            ->orWhere('id', $bookIdentifier)
            ->first();

        if (!$book) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json([
            'id' => $book->id,
            'uuid' => $book->uuid,
            'title' => $book->title,
            'author' => $book->author,
            'genre' => $book->genre,
            'published_year' => $book->published_year,
            'availability' => $book->availability ?? 0,
        ]);
    });

    Route::get('/media/images', [BookController::class, 'getMediaImages'])->name('api.media.images');
    Route::post('/media/upload-temp', [BookController::class, 'uploadTempImage'])->name('api.media.upload-temp');
    Route::post('/media/cleanup-temp', [BookController::class, 'cleanupTempImages'])->name('api.media.cleanup-temp');
});
