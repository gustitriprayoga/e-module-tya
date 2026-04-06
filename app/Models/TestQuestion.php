<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $fillable = [
        'type',
        'indicator',
        'question_text',
        'options',
        'correct_answer'
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }
}
