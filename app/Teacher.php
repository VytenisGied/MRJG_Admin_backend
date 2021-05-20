<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    public $timestamps = false;

    /**
     * One to one relationship with Teacher & People
     * @var array
     */
    public function person()
    {
        return $this->belongsTo(People::class, 'person_id');
    }

    public function classroom() {
        return $this->belongsToMany(Classroom::class, 'teacher_classroom_relations', 'teacher_id', 'classroom_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
