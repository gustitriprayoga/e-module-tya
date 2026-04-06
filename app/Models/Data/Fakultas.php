<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    // Karena nama tabelnya tidak menggunakan akhiran 's' di migrasi kita, kita definisikan manual
    protected $table = 'fakultas';
    protected $fillable = ['kode_fakultas', 'nama_fakultas'];

    public function prodis()
    {
        return $this->hasMany(Prodi::class);
    }
}
