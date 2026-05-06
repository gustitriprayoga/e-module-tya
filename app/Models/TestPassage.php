<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestPassage extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'title',
        'content',
        'order',
    ];

    /**
     * Get the test that owns the passage.
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Get the questions for the passage.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'test_passage_id');
    }
}
