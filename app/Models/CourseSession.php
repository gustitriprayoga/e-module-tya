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

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
