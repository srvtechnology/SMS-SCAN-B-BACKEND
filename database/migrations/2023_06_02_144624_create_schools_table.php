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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("created_by")->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string("username");
            $table->string("name");
            $table->string("email");
            $table->string("password");
            $table->string("contact_number");
            $table->string("landline_number");
            $table->string("affilliation_number");
            $table->string("board");
            $table->enum("type",["secondary","higher_secondary"]);
            $table->enum("medium",["english","bhutness","both"]);
            $table->longText("address");
            $table->string("image");
            $table->enum("status",['active','pending','blocked'])->default('active');
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
        Schema::dropIfExists('schools');
    }
};
