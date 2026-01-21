<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use App\Models\BookReturn;

class TransactionController extends Controller
{
public function index()
{
    $borrowed = Transaction::where('status', 'borrowed')
        ->with(['member', 'book'])
        ->orderBy('due_date')
        ->get();

    // Group borrowed transactions by member, date, and time
    $groupedBorrowed = $borrowed->groupBy(function ($transaction) {
        return $transaction->member_id . '_' . \Carbon\Carbon::parse($transaction->borrowed_at)->format('Y-m-d_H:i');
    })->map(function ($group) {
        return [
            'member' => $group->first()->member,
            'borrowed_at' => $group->first()->borrowed_at,
            'due_date' => $group->first()->due_date,
            'transactions' => $group
        ];
    })->values();

    $returned = Transaction::where('status', 'returned')
        ->with(['member', 'book'])
        ->orderByDesc('returned_at')
        ->get();

    return view('transactions.index', [
        'groupedBorrowed' => $groupedBorrowed,
        'returned' => $returned,
    ]);
}
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
public function returnBook($id)
{
    $transaction = Transaction::findOrFail($id);
    $transaction->status = 'returned';
    $transaction->returned_at = now();
    $transaction->save();

    $transaction->book->increment('availability');

    return redirect()->route('dashboard')->with('returned', 'success');
}

public function bulkReturn(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
        'book_ids' => 'required|array',
        'book_ids.*' => 'exists:books,id',
    ]);

    $returnedBooks = [];
    $errors = [];

    foreach ($validated['book_ids'] as $bookId) {
        // Find the transaction for this book and member
        $transaction = Transaction::where('book_id', $bookId)
            ->where('member_id', $validated['member_id'])
            ->where('status', 'borrowed')
            ->first();

        if ($transaction) {
            $transaction->status = 'returned';
            $transaction->returned_at = now();
            $transaction->save();

            $transaction->book->increment('availability');
            $returnedBooks[] = $transaction->book->title;
        } else {
            $book = Book::find($bookId);
            $errors[] = $book ? $book->title : "Book ID {$bookId}";
        }
    }

    if (count($returnedBooks) === 0) {
        return response()->json([
            'success' => false,
            'message' => 'No books were found to return for this member.'
        ]);
    }

    $message = 'Successfully returned: ' . implode(', ', $returnedBooks);
    if (count($errors) > 0) {
        $message .= '. Could not return: ' . implode(', ', $errors);
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'returned_count' => count($returnedBooks),
        'errors' => $errors
    ]);
}

public function overdue()
{
    $overdue = Transaction::where('status', 'borrowed')
        ->where('due_date', '<', now())
        ->with(['member', 'book'])
        ->get();

    return response()->json([
        'books' => $overdue->map(fn($t) => [
            'title' => $t->book->title ?? 'Unknown',
            'due_date' => $t->due_date->format('Y-m-d'),
            'member' => $t->member->name ?? 'Unknown'
        ])
    ]);
}



}
