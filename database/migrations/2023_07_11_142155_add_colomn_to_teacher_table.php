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
        Schema::table('staff', function (Blueprint $table) {
            $table->unsignedBigInteger('assign_class_to_class_teacher')->nullable()->after('school_id');
            $table->foreign('assign_class_to_class_teacher')->references('id')->on('classes');

            $table->unsignedBigInteger('assign_section_to_class_teacher')->nullable()->after('assign_class_to_class_teacher');
            $table->foreign('assign_section_to_class_teacher')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['assign_class_to_class_teacher']);
            $table->dropColumn('assign_class_to_class_teacher');

            $table->dropForeign(['assign_section_to_class_teacher']);
            $table->dropColumn('assign_section_to_class_teacher');
        });
    }
};
