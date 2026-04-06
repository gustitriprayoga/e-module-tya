<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            // Jika fakultas dihapus, prodi tidak ikut terhapus tapi nilainya jadi null
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->nullOnDelete();
            $table->string('kode_prodi')->nullable()->unique(); // Menyimpan id_sms prodi dari API
            $table->string('nama_prodi'); // Menyimpan nm_lemb prodi
            $table->string('jenjang')->nullable(); // S1, S2, D3, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
