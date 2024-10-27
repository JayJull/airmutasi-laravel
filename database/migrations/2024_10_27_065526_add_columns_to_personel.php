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
        Schema::table('personels', function (Blueprint $table) {
            $table->string("e_nik")->default("0");
            $table->string("nik_ap1")->default("0");
            $table->string("gelar")->nullable();
            $table->enum("kelamin", ['L', 'P'])->default('L');
            $table->string("tempat_lahir")->default("-");
            $table->date("tgl_lahir")->default("2000-01-01");
            $table->integer("usia_th")->default(0);
            $table->integer("usia_bl")->default(0);
            $table->string("sts_karyawan")->default("-");	
            $table->date("tmt_kerja_airnav")->default("2000-01-01");
            $table->date("tmt_kerja_golongan")->default("2000-01-01");
            $table->date("tmt_pensiun")->default("2000-01-01");
            $table->foreignId("lokasi")->nullable()->constrained("cabangs")->onDelete("cascade");
            $table->foreignId("lokasi_induk")->nullable()->constrained("cabangs")->onDelete("cascade");
            $table->string("unit")->default("-");
            $table->date("tmt_jabatan")->default("2000-01-01");
            $table->integer("masa_kerja_jabatan_bl")->default(0);
            $table->string("nama_level_jabatan")->default("-");
            $table->date("tmt_level_jabatan")->default("2000-01-01");
            $table->integer("masa_kerja_level_jabatan_th")->default(0);
            $table->integer("masa_kerja_level_jabatan_bl")->default(0);
            $table->integer("skala_jabatan")->default(0);
            $table->string('fungsi')->default("-");
            $table->string("job_text")->default("-");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personels', function (Blueprint $table) {
            $table->dropColumn("e_nik");
            $table->dropColumn("nik_ap1");	
            $table->dropColumn("gelar");
            $table->dropColumn("kelamin");
            $table->dropColumn("tempat_lahir");
            $table->dropColumn("tgl_lahir");	
            $table->dropColumn("usia_th");	
            $table->dropColumn("usia_bl");
            $table->dropColumn("sts_karyawan");	
            $table->dropColumn("tmt_kerja_airnav");
            $table->dropColumn("tmt_kerja_golongan");
            $table->dropColumn("tmt_pensiun");
            $table->dropColumn("lokasi");
            $table->dropColumn("lokasi_induk");
            $table->dropColumn("unit");
            $table->dropColumn("tmt_jabatan");
            $table->dropColumn("masa_kerja_jabatan_bl");
            $table->dropColumn("nama_level_jabatan");
            $table->dropColumn("tmt_level_jabatan");
            $table->dropColumn("masa_kerja_level_jabatan_th");
            $table->dropColumn("masa_kerja_level_jabatan_bl");
            $table->dropColumn("skala_jabatan");
            $table->dropColumn('fungsi');
            $table->dropColumn("job_text");
        });
    }
};
