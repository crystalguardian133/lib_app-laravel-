<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePhotoColumnInMembersTable extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Add photo column if it doesn't exist
            if (!Schema::hasColumn('members', 'photo')) {
                $table->string('photo')->nullable()->after('contactnumber');
            }
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}
