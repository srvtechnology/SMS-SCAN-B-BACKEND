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
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->bigInteger("exam_id")->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->bigInteger("class_id")->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->bigInteger("section_id")->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->bigInteger("staff_id")->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->bigInteger("subject_id")->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->bigInteger("student_id")->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->decimal('obtained_marks');
            $table->decimal('total_marks');
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
        Schema::dropIfExists('student_results');
    }
};
