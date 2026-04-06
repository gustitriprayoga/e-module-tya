<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'module_id', 
        'title', 
        'order_number', 
        'is_published'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class)->orderBy('sort_order');
    }
}