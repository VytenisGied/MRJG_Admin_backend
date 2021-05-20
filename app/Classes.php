<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    public $timestamps = false;

    /**
     * One to one relationship with Class & Person
     * @var array
     */
    public function schoolmaster()
    {
        return $this->belongsToThrough(People::class, Teacher::class,
        null,
        '',
        [Teacher::class => 'schoolmaster_id']);
    }

    /**
     * One to Many relationship with Parent & People
     * @var array
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
