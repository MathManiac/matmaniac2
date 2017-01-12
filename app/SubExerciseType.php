<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubExerciseType extends Model
{
    protected $fillable = ['exercise_type_id', 'name'];

    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'sub_exercise_id');
    }
}
