<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function columns()
    {
        return $this->hasMany(SubjectColumn::class);
    }
}
