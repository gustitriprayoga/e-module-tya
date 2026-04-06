<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = ['fakultas_id', 'kode_prodi', 'nama_prodi', 'jenjang'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }
}
