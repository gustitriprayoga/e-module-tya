<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    protected $fillable = [
        'user_id',
        'block_id',
        'duration_seconds',
        'wpm_result',
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
}
