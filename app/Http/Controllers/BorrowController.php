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

        // ✅ Enhanced member lookup with multiple strategies
        $memberName = trim($validated['member_name']);

        // Strategy 1: Use model's name attribute (recommended)
        $member = Member::where('first_name', 'LIKE', '%' . $memberName . '%')
                       ->orWhere('last_name', 'LIKE', '%' . $memberName . '%')
                       ->orWhere(DB::raw("CONCAT_WS(' ', first_name, COALESCE(middle_name, ''), last_name)"), 'LIKE', '%' . $memberName . '%')
                       ->first();

        // Strategy 2: If no match, try partial name matching
        if (!$member) {
            $nameParts = explode(' ', $memberName);
            if (count($nameParts) >= 2) {
                $firstName = $nameParts[0];
                $lastName = $nameParts[count($nameParts) - 1];

                $member = Member::where('first_name', 'LIKE', '%' . $firstName . '%')
                               ->where('last_name', 'LIKE', '%' . $lastName . '%')
                               ->first();
            }
        }

        // Strategy 3: If still no match, try case-insensitive search
        if (!$member) {
            $member = Member::where(DB::raw('LOWER(first_name)'), 'LIKE', '%' . strtolower($memberName) . '%')
                           ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . strtolower($memberName) . '%')
                           ->first();
        }

        if (!$member) {
            // Get all members for debugging (remove in production)
            $allMembers = Member::select('first_name', 'middle_name', 'last_name')->get();
            return response()->json([
                'message' => '❌ Member not found.',
                'searched_name' => $memberName,
                'available_members' => $allMembers->map(function($m) {
                    return [
                        'name' => trim($m->first_name . ' ' . ($m->middle_name ?? '') . ' ' . $m->last_name),
                        'first_name' => $m->first_name,
                        'last_name' => $m->last_name
                    ];
                })
            ], 404);
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
    public function show($id)
{
    $member = Member::find($id);
    if (!$member) return response()->json(['error' => 'Not found'], 404);

    return response()->json([
        'id' => $member->id,
        'first_name' => $member->first_name,
        'middle_name' => $member->middle_name,
        'last_name' => $member->last_name,
    ]);
}   
public function getOverdueAndDueSoon()
{
    $now = now();
    $inThreeDays = now()->addDays(3)->endOfDay();

    $activeTransactions = \App\Models\Transaction::with(['member', 'book'])
        ->where('status', 'borrowed')
        ->get();

    $overdue = [];
    $dueSoon = [];

    foreach ($activeTransactions as $t) {
        try {
            $dueDate = \Illuminate\Support\Carbon::parse($t->due_date);
        } catch (\Exception $e) {
            continue;
        }

        if ($dueDate->lessThan($now)) {
            $overdue[] = $t;
        } elseif ($dueDate->lessThanOrEqualTo($inThreeDays)) {
            $dueSoon[] = $t;
        }
    }

    $format = function ($items) {
        return collect($items)->map(function ($t) {
            $m = $t->member;
            $name = $m ? trim("$m->first_name $m->middle_name $m->last_name") : 'Unknown Member';
            $title = $t->book?->title ?? 'Unknown Title';

            return ['member' => $name, 'title' => $title];
        });
    };

    return response()->json([
        'overdue' => $format($overdue),
        'dueSoon'  => $format($dueSoon),
    ]);
}
}
