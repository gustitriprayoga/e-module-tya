<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'completed_at',
    ];

    // Relasi agar kita tahu nilai ini milik siapa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi agar kita tahu ini nilai dari ujian apa
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
