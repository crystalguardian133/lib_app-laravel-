<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
     public function search(Request $request)   
    {
    $query = $request->input('query');
    $members = Member::where('name', 'LIKE', '%' . $query . '%')->pluck('name');
    return response()->json($members);
    }

    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'member_name' => 'required|string',
            'due_date'    => 'required|date|after_or_equal:today',
            'book_ids'    => 'required|array|min:1',
            'book_ids.*'  => 'integer|exists:books,id'
        ]);

        $member = Member::where('name', $validated['member_name'])->first();

        if (!$member) {
            return response()->json(['message' => '❌ Member not found.'], 404);
        }

        $borrowedBooks = [];

        foreach ($validated['book_ids'] as $bookId) {
            $book = Book::find($bookId);
            if (!$book) continue;

            if ($book->availability < 1) {
                return response()->json([
                    'message' => "🚫 '{$book->title}' is not available for borrowing."
                ], 400);
            }

            DB::table('transactions')->insert([
                'member_id'   => $member->id,
                'book_id'     => $book->id,
                'borrowed_at' => now(),
                'due_date'    => $validated['due_date'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $book->decrement('availability');
            $borrowedBooks[] = $book->title;
        }

        return response()->json([
            'message' => '✅ Borrowing completed.',
            'borrowed_books' => $borrowedBooks
        ]);
    }
}
