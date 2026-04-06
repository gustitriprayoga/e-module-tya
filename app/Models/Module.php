<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'cover_image', 
        'is_active'
    ];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order_number');
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class);
    }
}
