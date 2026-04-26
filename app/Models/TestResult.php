<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    // Tambahkan 'answers' ke fillable agar bisa disimpan
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'answers',
        'completed_at',
    ];

    // Tambahkan casts agar string JSON otomatis jadi array di Laravel
    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
