<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('age')->nullable();
            $table->string('address')->nullable();
            $table->string('contactnumber')->nullable();
            $table->string('school')->nullable();
            $table->timestamp('memberdate')->useCurrent();
            $table->integer('member_time')->default(0); // For computer usage time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}
