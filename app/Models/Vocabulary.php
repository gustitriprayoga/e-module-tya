<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = [
        'module_id',
        'level',
        'word',
        'category',
        'definition',
        'context_sentence'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
