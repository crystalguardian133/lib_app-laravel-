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
        Schema::table('members', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id')->unique();
        });

        DB::table('members')
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($members) {
                foreach ($members as $member) {
                    DB::table('members')
                        ->where('id', $member->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });

    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
