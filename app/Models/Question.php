<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id', 'test_passage_id', 'passage', 'question_text', 'indicator', 'explanation'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testPassage()
    {
        return $this->belongsTo(TestPassage::class, 'test_passage_id');
    }
}
