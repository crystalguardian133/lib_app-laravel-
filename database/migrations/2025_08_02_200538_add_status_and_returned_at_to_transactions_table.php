<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndReturnedAtToTransactionsTable extends Migration
{
    public function up()
    {
      Schema::table('transactions', function (Blueprint $table) {
        $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
        $table->timestamp('returned_at')->nullable();
    });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['status', 'returned_at']);
        });
    }
}
