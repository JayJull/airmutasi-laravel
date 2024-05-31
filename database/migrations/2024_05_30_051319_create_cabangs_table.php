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
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('nama');
            $table->text("alamat");
            $table->string('thumbnail');
            $table->bigInteger('cabang_induk_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table("cabangs", function (Blueprint $table) {
            $table->foreign('cabang_induk_id')->references('id')->on('cabangs')->onDelete('cascade');
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
