<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get some members and books
        $members = Member::take(5)->get();
        $books = Book::take(10)->get();

        if ($members->isEmpty() || $books->isEmpty()) {
            $this->command->info('No members or books found. Skipping transaction seeding.');
            return;
        }

        // Create some sample transactions
        $transactions = [
            [
                'member_id' => $members->first()->id,
                'book_id' => $books->first()->id,
                'borrowed_at' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(10),
                'returned_at' => null,
            ],
            [
                'member_id' => $members->skip(1)->first()->id ?? $members->first()->id,
                'book_id' => $books->skip(1)->first()->id ?? $books->first()->id,
                'borrowed_at' => Carbon::now()->subDays(3),
                'due_date' => Carbon::now()->addDays(12),
                'returned_at' => Carbon::now()->subDays(1),
            ],
            [
                'member_id' => $members->skip(2)->first()->id ?? $members->first()->id,
                'book_id' => $books->skip(2)->first()->id ?? $books->first()->id,
                'borrowed_at' => Carbon::now()->subDays(7),
                'due_date' => Carbon::now()->addDays(8),
                'returned_at' => null,
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }

        $this->command->info('Sample transactions created successfully.');
    }
}