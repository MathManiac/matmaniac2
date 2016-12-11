<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubExerciseType extends Model
{
    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class);
    }
}
