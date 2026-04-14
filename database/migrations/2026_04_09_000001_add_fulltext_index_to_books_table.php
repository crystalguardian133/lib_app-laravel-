<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add FULLTEXT index for title, author, genre
        DB::statement('ALTER TABLE books ADD FULLTEXT fulltext_index (title, author, genre)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE books DROP INDEX fulltext_index');
    }
};
