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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('image');
            $table->string('phone');
            $table->string('gender');
            $table->bigInteger("designation_id")->unsigned();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->longText('address');
            $table->string('salary');
            $table->string('joining_date');
            $table->string('additional_documents')->nullable();
            $table->string('fb_profile')->nullable();
            $table->string('insta_profile')->nullable();
            $table->string('linkedIn_profile')->nullable();
            $table->string('twitter_profile')->nullable();
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
        Schema::dropIfExists('staff');
    }
};
