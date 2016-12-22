<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionInput extends Model
{
    protected $fillable = [
        'input', 'correct'
    ];

    protected $casts = [
        'input' => 'array'
    ];
}
