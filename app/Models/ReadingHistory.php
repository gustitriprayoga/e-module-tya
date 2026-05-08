<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    protected $fillable = [
        'user_id',
        'module_id',
        'block_id',
        'time_spent',
        'wpm',
        'total_words',
        'quiz_correct',
        'quiz_total',
        'accuracy_score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
