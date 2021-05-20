<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stream extends Model
{
    public $timestamps = false;
    
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
