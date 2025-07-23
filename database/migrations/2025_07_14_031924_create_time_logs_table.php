<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('time_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('member_id');
        $table->timestamp('time_in')->nullable();
        $table->timestamp('time_out')->nullable();
        $table->timestamps();

        $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_logs');
    }
};
