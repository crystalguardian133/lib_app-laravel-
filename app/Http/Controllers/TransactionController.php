<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;

class TransactionController extends Controller
{
    public function borrow(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
        'book_ids' => 'required|array',
        'book_ids.*' => 'exists:books,id',
    ]);

    $borrowedBooks = [];

    foreach ($validated['book_ids'] as $bookId) {
        $book = Book::find($bookId);

        if ($book->availability > 0) {
            Transaction::create([
                'book_id' => $bookId,
                'member_id' => $validated['member_id'],
            ]);

            $book->decrement('availability');
            $borrowedBooks[] = $book->title;
        }
    }

    if (count($borrowedBooks) === 0) {
        return back()->with('error', 'No books were available to borrow.');
    }

    return back()->with('success', 'Borrowed books: ' . implode(', ', $borrowedBooks));
}

}
