<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'generator', 'validator', 'status', 'options', 'sub_exercise_id'
    ];

    protected $casts = [
        'options' => 'array'
    ];

}
