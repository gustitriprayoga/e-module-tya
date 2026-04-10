<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'content',
        'is_published',
        'order',
    ];

    // TAMBAHKAN BLOK INI: Agar database paham ini adalah Boolean (True/False)
    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
