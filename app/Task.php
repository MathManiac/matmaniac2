<?php

namespace App;

use App\Opgaver\TaskRepository\Resolver;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'generator', 'validator', 'status', 'options', 'sub_exercise_id'
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
}
