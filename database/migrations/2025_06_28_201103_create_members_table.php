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

    // Full Name segments
    $table->string('first_name');
    $table->string('middle_name')->nullable();
    $table->string('last_name');

    $table->unsignedInteger('age')->nullable();

    // Address segments
    $table->string('house_number')->nullable();
    $table->string('street') ->nullable();
    $table->string('barangay');
    $table->string('municipality');
    $table->string('province');

    // Contact and school
    $table->string('contactnumber')->nullable();
    $table->string('school')->nullable();

    // Auto fields
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
