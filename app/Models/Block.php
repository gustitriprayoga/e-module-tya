<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'page_id', 
        'type', 
        'content', 
        'settings', 
        'sort_order'
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'settings' => 'array',
        ];
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}