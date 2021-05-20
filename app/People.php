<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * One to one relationship with Student & People
     * @var array
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    /**
     * One to one relationship with Teacher & People
     * @var array
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    /**
     * One to one relationship with Parent & People
     * @var array
     */
    public function parent()
    {
        return $this->hasOne(Parent::class);
    }
    
    /**
     * One to one relationship with Teacher & Classes
     * @var array
     */
    public function classes()
    {
        return $this->hasOneThrough(Classes::class, Teacher::class, 'person_id', 'schoolmaster_id', 'id', 'id');
    }
}
