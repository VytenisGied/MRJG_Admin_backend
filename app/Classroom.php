<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    public $timestamps = false;

    /**
     * One to one relationship with Classroom & Subject
     * @var array
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher() {
        return $this->belongsToMany(Teacher::class, 'teacher_classroom_relations', 'classroom_id', 'teacher_id');
    }
}
