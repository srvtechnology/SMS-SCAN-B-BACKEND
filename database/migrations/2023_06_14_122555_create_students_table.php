<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->bigInteger("parent_id")->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
            $table->string("parent_type")->nullable();
            $table->bigInteger("sibling_id")->default(0);
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('image');
            $table->string('phone');
            $table->string('gender');
            $table->longText('address');
            $table->longText('permanent_address');
            $table->string('dob');
            $table->string('admission_date');
            $table->string('bg_school_name')->nullable();
            $table->string('bg_class_name')->nullable();
            $table->string('school_leave_certificate')->nullable();
            $table->string('mark_sheet')->nullable();
            $table->bigInteger("created_by")->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum("is_deleted",["0","1"])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
