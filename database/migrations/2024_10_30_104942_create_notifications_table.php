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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("status");
            $table->foreignId("to")->constrained("cabangs")->onDelete("cascade");
            $table->boolean("is_read")->default(false);
            $table->foreignId("cabang_asal_id")->constrained("cabangs")->onDelete("cascade");
            $table->foreignId("cabang_tujuan_id")->constrained("cabangs")->onDelete("cascade");
            $table->foreignId("pengajuan_id")->constrained("pengajuans")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
