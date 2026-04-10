<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['passage', 'question_text', 'indicator', 'explanation'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
