<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the old timestamp column if it exists
            if (Schema::hasColumn('users', 'force_logout_at')) {
                $table->dropColumn('force_logout_at');
            }
            // Add the new boolean column
            $table->boolean('force_logout')->default(false)->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('force_logout');
        });
    }
};
