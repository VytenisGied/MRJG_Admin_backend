<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grades extends Model
{
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
        // return $this->belongsToThrough(People::class, Student::class,
        // null,
        // '',
        // [Student::class => 'student_id']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
