<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = Transaction::with(['member', 'book'])->orderBy('borrowed_at', 'desc')->get();
    return view('transactions.index', compact('transactions'));
   
    $overdueMembers = Transaction::where('status', 'borrowed')
    ->whereDate('due_date', '<', now())
    ->with('member')
    ->get()
    ->pluck('member.name')
    ->unique()
    ->values();

return view('transactions.index', [
    'transactions' => $transactions,
    'overdueMembers' => $overdueMembers
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

    if ($transaction->status !== 'borrowed') {
        return back()->with('error', 'This book is already returned.');
    }

    $transaction->status = 'returned';
    $transaction->returned_at = now();
    $transaction->save();

    // Restore book availability
    $transaction->book->increment('availability');

    return back()->with('success', 'Book returned successfully.');
}


}
