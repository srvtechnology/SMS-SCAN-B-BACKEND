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
        Schema::create('time_table_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("school_id")->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->bigInteger("from_class")->unsigned();
            $table->foreign('from_class')->references('id')->on('classes')->onDelete('cascade');
            $table->bigInteger("to_class")->unsigned();
            $table->foreign('to_class')->references('id')->on('classes')->onDelete('cascade');
            $table->string("class_range");
            $table->string("start_time");
            $table->string("end_time");
            $table->string("weekdays");
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
        Schema::dropIfExists('time_table_settings');
    }
};
