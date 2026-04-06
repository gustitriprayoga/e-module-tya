<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // WAJIB ADA UNTUK SPATIE

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim_nip',  // Tambahkan ini
        'username', // Tambahkan ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI UNTUK FITUR R&D READING II ---

    // Riwayat WPM & Latihan Membaca Mahasiswa
    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    // Skor Pre-test, Post-test, dan N-Gain
    public function researchAnalytic()
    {
        return $this->hasOne(ResearchAnalytic::class);
    }

    // Relasi ke Data Mahasiswa Akademik
    public function dataMahasiswa()
    {
        return $this->hasOne(\App\Models\Data\Mahasiswa::class);
    }

    // Relasi ke Data Dosen Akademik
    public function dataDosen()
    {
        return $this->hasOne(\App\Models\Data\Dosen::class);
    }
}
