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
        Schema::create('home_works', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->bigInteger("created_by_staff")->unsigned();
            $table->foreign('created_by_staff')->references('id')->on('staff')->onDelete('cascade');
            $table->bigInteger("class_id")->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->bigInteger("section_id")->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string("type")->default("homework");
            $table->longText("title");
            $table->longText("description")->nullable();
            $table->longText("files")->nullable();
            $table->date("due_date")->nullable();
            $table->datetime("date");
            $table->string("status")->default("pending");
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
        Schema::dropIfExists('home_works');
    }
};
