<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Member;
use App\Models\Book;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\Authenticate;

// Demographics API (must be before wildcard routes)
Route::get('/members/demographics', [MemberController::class, 'getDemographicsData']);

// Clean API route for getting member info
Route::get('/members/{id}', [MemberController::class, 'apiShow']);

Route::get('/members/{id}', function ($id) {
    $member = Member::find($id);
    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json(['name' => $member->name]);
});

// Fallback route
Route::get('/members/{id}', [MemberController::class, 'apiShow']);

// Books API
Route::get('/books/{id}', function ($id) {
    $book = Book::find($id);
    if (!$book) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json([
        'id' => $book->id,
        'title' => $book->title,
        'author' => $book->author,
        'genre' => $book->genre
    ]);
});

// Bulk return API
Route::post('/returns/bulk', [TransactionController::class, 'bulkReturn']);

