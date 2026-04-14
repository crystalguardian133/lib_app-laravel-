<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;

Route::middleware(['web', 'auth', 'permission:manage-members'])->group(function () {
    Route::get('/members/demographics', [MemberController::class, 'getDemographicsData']);
    Route::get('/members/{memberIdentifier}', [MemberController::class, 'apiShow']);
});

// Book data endpoint accessible to all authenticated users for borrow operations
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/books/{id}', function ($id) {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'genre' => $book->genre,
            'published_year' => $book->published_year,
            'availability' => $book->availability ?? 0,
        ]);
    });
});

Route::middleware(['web', 'auth', 'permission:manage-books'])->group(function () {
    Route::get('/books/genres', [BookController::class, 'allGenres']);
});

Route::middleware(['web', 'auth', 'permission:return-books|manage-books'])->group(function () {
    Route::post('/returns/bulk', [TransactionController::class, 'bulkReturn']);
});

