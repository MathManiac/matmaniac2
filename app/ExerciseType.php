<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseType extends Model
{
    public function subExercises()
    {
        return $this->hasMany(SubExerciseType::class);
    }
}
