<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Session;

class Module extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'is_active',
        'is_published', // Tambahkan ini
        'order',        // Tambahkan ini
    ];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order_number');
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function courseSessions()
    {
        return $this->hasMany(CourseSession::class);
    }
}
