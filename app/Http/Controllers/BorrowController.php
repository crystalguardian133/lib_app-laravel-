<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|integer|exists:members,id',
        'book_ids'  => 'required|array',
        'due_date'  => 'required|date|after_or_equal:today',
    ]);

    $member = Member::find($validated['member_id']);

    foreach ($validated['book_ids'] as $bookId) {
        $book = Book::find($bookId);

        if (!$book || $book->availability <= 0) {
            return response()->json([
                'success' => false,
                'message' => "❌ Book with ID $bookId is unavailable.",
            ], 400);
        }

        Transaction::create([
            'member_id'   => $member->id,
            'book_id'     => $bookId,
            'borrow_date' => now(),
            'due_date'    => $validated['due_date'],
        ]);

        $book->decrement('availability');
    }

    return response()->json([
        'success' => true,
        'message' => '✅ Books successfully borrowed!',
    ]);
}

    public function getMemberById($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $fullName = trim("{$member->first_name} {$member->middle_name} {$member->last_name}");
        $fullName = str_replace([' null', 'null '], '', $fullName);

        return response()->json([
            'name' => $fullName
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Generate full names dynamically
        $members = Member::select(
            DB::raw("TRIM(CONCAT_WS(' ', first_name, NULLIF(middle_name, ''), last_name)) as name")
        )
        ->where(DB::raw("TRIM(CONCAT_WS(' ', first_name, NULLIF(middle_name, ''), last_name))"), 'LIKE', '%' . $query . '%')
        ->pluck('name');

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

        // ✅ Fix member lookup
        $member = Member::where(
            DB::raw("CONCAT_WS(' ', first_name, COALESCE(middle_name, ''), last_name)"),
            $validated['member_name']
        )->first();

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
