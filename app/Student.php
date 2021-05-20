<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * One to one relationship with Student & People
     * @var array
     */
    public function people()
    {
        return $this->belongsTo(People::class, 'person_id');
    }
    /**
     * One to one relationship with Student & People
     * @var array
     */
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
