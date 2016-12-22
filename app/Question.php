<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question', 'previous', 'skipped'
    ];

    public function inputs()
    {
        return $this->hasMany(QuestionInput::class);
    }

    public function previous()
    {
        return $this->hasOne(Question::class, 'previous_id');
    }

    public function solved()
    {
        if ($this->skipped)
            return false;
        $lastInput = $this->inputs()->orderBy('id', 'desc')->first();
        return (bool)$lastInput->correct;
    }
}
