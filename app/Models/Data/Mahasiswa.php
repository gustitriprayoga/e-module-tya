<?php

namespace App\Models\Data;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['user_id', 'prodi_id', 'nim', 'nama_lengkap', 'angkatan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
