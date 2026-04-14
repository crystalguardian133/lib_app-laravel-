<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // For all books, migrate genre string to genres array if not already set
        Book::whereNotNull('genre')->where(function($q){
            $q->whereNull('genres')->orWhere('genres', '[]');
        })->chunk(100, function($books) {
            foreach ($books as $book) {
                $genres = preg_split('/\s*[,\/&;|\\\\]+\s*/', $book->genre) ?: [];
                $genres = array_values(array_unique(array_filter(array_map('trim', $genres), fn ($g) => $g !== '')));
                $book->genres = $genres;
                $book->save();
            }
        });
    }

    public function down()
    {
        // No-op: do not revert genres array
    }
};
