<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->index('uuid');
        });

        DB::table('books')
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($books) {
                foreach ($books as $book) {
                    DB::table('books')
                        ->where('id', $book->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });

        Schema::table('books', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropIndex(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
