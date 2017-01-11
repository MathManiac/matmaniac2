<?php

namespace App;

use App\Opgaver\TaskRepository\Resolver;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'generator', 'validator', 'status', 'options', 'sub_exercise_id', 'chained_to'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function allInputsAnswered()
    {
        $taskResolver = app()->make(Resolver::class);
        return $taskResolver->allInputsAnswered($this);
    }

    public function getQuestion($withResult = false)
    {
        $taskResolver = app()->make(Resolver::class);
        return $taskResolver->generateQuestion($this, $withResult);
    }

    public function previous()
    {
        return $this->belongsTo(Task::class, 'chained_to');
    }

    public function upcoming()
    {
        return $this->hasMany(Task::class, 'chained_to');
    }

    public function previousList()
    {
        $taskResolver = app()->make(Resolver::class);
        return $taskResolver->chain($this);
    }

    public function SubExerciseType()
    {
        return $this->belongsTo(SubExerciseType::class, 'sub_exercise_id');
    }
}
