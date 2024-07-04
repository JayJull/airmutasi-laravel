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
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text("alamat");
            $table->string('thumbnail_url')->nullable();

            $table->integer("jumlah_personel");
            $table->integer("formasi");
            $table->integer("frms");
            
            $table->integer("jumlah_personel_aco")->default(0);
            $table->integer("formasi_aco")->default(0);
            $table->integer("frms_aco")->default(0);
            
            $table->integer("jumlah_personel_ais")->default(0);
            $table->integer("formasi_ais")->default(0);
            $table->integer("frms_ais")->default(0);
            
            $table->integer("jumlah_personel_atfm")->default(0);
            $table->integer("formasi_atfm")->default(0);
            $table->integer("frms_atfm")->default(0);
            
            $table->integer("jumlah_personel_tapor")->default(0);
            $table->integer("formasi_tapor")->default(0);
            $table->integer("frms_tapor")->default(0);
            
            $table->integer("jumlah_personel_ats_system")->default(0);
            $table->integer("formasi_ats_system")->default(0);
            $table->integer("frms_ats_system")->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabangs');
    }
};
