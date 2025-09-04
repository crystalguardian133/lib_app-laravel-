<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->timestamp('returned_at')->useCurrent();
            $table->timestamps();

            $table->foreign('transaction_id')
                  ->references('id')->on('transactions')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('returns');
    }
}
