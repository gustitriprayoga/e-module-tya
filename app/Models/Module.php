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

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function isLockedForUser($user)
    {
        // Logika: Modul terkunci jika user belum menyelesaikan Pre-test
        // Anda bisa menyesuaikan ini, misalnya: Modul 2 terkunci jika Modul 1 belum selesai.
        $hasCompletedPreTest = \App\Models\TestResult::where('user_id', $user->id)
            ->whereHas('test', function ($q) {
                $q->where('type', 'pre-test');
            })->exists();

        return !$hasCompletedPreTest;
    }
}
