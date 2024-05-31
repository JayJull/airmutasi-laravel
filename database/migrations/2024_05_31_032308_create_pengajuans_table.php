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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_awal_id')->constrained('cabangs');
            $table->foreignId('lokasi_tujuan_id')->constrained('cabangs');
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->integer('masa_kerja');
            $table->string('jabatan');
            $table->string('posisi_sekarang');
            $table->string('posisi_tujuan');
            $table->string('kompetensi');
            $table->string('tujuan_rotasi');
            $table->text('keterangan');
            $table->enum('status', ['selektif', 'diterima', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
