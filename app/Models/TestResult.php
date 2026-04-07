<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['user_id', 'test_type', 'indicator_scores', 'total_score'];

    protected function casts(): array
    {
        return [
            'indicator_scores' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
