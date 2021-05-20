<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Timetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable', function (Blueprint $table) {
            $table->id();
            $table->string('weekday');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('classroom_id');
            $table->smallInteger('lesson');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('stream_id')->nullable();
            $table->unsignedBigInteger('subject_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timetable');
    }
}
