<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Model
{
    public $timestamps = false;

    /**
     * One to one relationship with Student & People
     * @var array
     */
    public function people()
    {
        return $this->belongsTo(People::class, 'person_id');
    }
}
