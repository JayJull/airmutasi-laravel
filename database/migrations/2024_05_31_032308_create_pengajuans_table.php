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
            $table->foreignId('lokasi_awal_id')->constrained('cabangs')->cascadeOnDelete();
            $table->foreignId('lokasi_tujuan_id')->constrained('cabangs')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->integer('masa_kerja');
            $table->string('sk_mutasi_url')->nullable();
            $table->string('jabatan');
            $table->string('posisi_sekarang');
            $table->string('posisi_tujuan');
            $table->string('tujuan_rotasi');
            $table->string('surat_persetujuan_url')->nullable();
            $table->text('keterangan');
            $table->enum('status', ['diajukan', 'dapat', 'tidak_dapat', 'diterima']);
            $table->foreignId('secondary_pengajuan_id')->nullable()->constrained('pengajuans')->cascadeOnDelete();
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
