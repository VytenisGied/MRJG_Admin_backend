<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relations1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('people', function (Blueprint $table) {        
        //     $table->foreign('contacts_id')->references('id')->on('contacts');
        // });
        Schema::table('teachers', function (Blueprint $table) {        
            $table->foreign('person_id')->references('id')->on('people');
        });
        Schema::table('students', function (Blueprint $table) {        
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('class_id')->references('id')->on('classes');
        });
        Schema::table('parents', function (Blueprint $table) {        
            $table->foreign('person_id')->references('id')->on('people');
        });
        Schema::table('grades', function (Blueprint $table) {        
            $table->foreign('student_id')->references('id')->on('students');
        });
        Schema::table('streams', function (Blueprint $table) {        
            $table->foreign('student_id')->references('id')->on('students');
        });
        Schema::table('classes', function (Blueprint $table) {        
            $table->foreign('schoolmaster_id')->references('id')->on('teachers');
        });
        Schema::table('timetable', function (Blueprint $table) {        
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('stream_id')->references('id')->on('streams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('people', function (Blueprint $table) {        
        //     $table->dropForeign('people_contacts_id_foreign');
        // });
        Schema::table('teachers', function (Blueprint $table) {        
            $table->dropForeign('teachers_person_id_foreign');
        });
        Schema::table('students', function (Blueprint $table) {        
            $table->dropForeign('students_person_id_foreign');
            $table->dropForeign('students_class_id_foreign');
        });
        Schema::table('parents', function (Blueprint $table) {        
            $table->dropForeign('parents_person_id_foreign');
        });
        Schema::table('grades', function (Blueprint $table) {        
            $table->dropForeign('grades_student_id_foreign');
        });
        Schema::table('streams', function (Blueprint $table) {        
            $table->dropForeign('streams_student_id_foreign');
        });
        Schema::table('classes', function (Blueprint $table) {        
            $table->dropForeign('classes_schoolmaster_id_foreign');
        });
        Schema::table('timetable', function (Blueprint $table) {        
            $table->dropForeign('timetable_teacher_id_foreign');
            $table->dropForeign('timetable_classroom_id_foreign');
            $table->dropForeign('timetable_class_id_foreign');
            $table->dropForeign('timetable_stream_id_foreign');
        });
    }
}
