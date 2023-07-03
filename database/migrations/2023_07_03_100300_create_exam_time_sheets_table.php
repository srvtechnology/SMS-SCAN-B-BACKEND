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
        Schema::create('exam_time_sheets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->bigInteger("exam_id")->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->bigInteger("class_id")->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->bigInteger("subject_id")->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
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
        Schema::dropIfExists('exam_time_sheets');
    }
};
