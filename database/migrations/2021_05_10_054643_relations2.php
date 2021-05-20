<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relations2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {        
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
        Schema::table('classrooms', function (Blueprint $table) {        
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
        Schema::table('grades', function (Blueprint $table) {        
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
        Schema::table('timetable', function (Blueprint $table) {        
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
        Schema::table('student_choices', function (Blueprint $table) {        
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
        Schema::table('teacher_classroom_relations', function (Blueprint $table) {        
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
        Schema::table('student_class_appointments', function (Blueprint $table) {        
            $table->foreign('student_id')->references('id')->on('students');
        });
        Schema::table('student_parent_relations', function (Blueprint $table) {        
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('parent_id')->references('id')->on('parents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {        
            $table->dropForeign('teachers_subject_id_foreign');
        });
        Schema::table('classrooms', function (Blueprint $table) {        
            $table->dropForeign('classrooms_subject_id_foreign');
        });
        Schema::table('grades', function (Blueprint $table) {        
            $table->dropForeign('grades_subject_id_foreign');
        });
        Schema::table('timetable', function (Blueprint $table) {        
            $table->dropForeign('timetable_subject_id_foreign');
        });
        Schema::table('student_choices', function (Blueprint $table) {        
            $table->dropForeign('student_choices_student_id_foreign');
            $table->dropForeign('student_choices_subject_id_foreign');
        });
        Schema::table('teacher_classroom_relations', function (Blueprint $table) {        
            $table->dropForeign('teacher_classroom_relations_teacher_id_foreign');
            $table->dropForeign('teacher_classroom_relations_classroom_id_foreign');
        });
        Schema::table('student_class_appointments', function (Blueprint $table) {        
            $table->dropForeign('student_class_appointments_student_id_foreign');
        });
        Schema::table('student_class_appointments', function (Blueprint $table) {        
            $table->dropForeign('student_parent_relations_student_id_foreign');
            $table->dropForeign('student_parent_relations_parent_id_foreign');
        });
    }
}
