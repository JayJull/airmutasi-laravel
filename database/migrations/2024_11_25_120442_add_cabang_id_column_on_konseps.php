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
        Schema::table('konseps', function (Blueprint $table) {
            $table->foreignId('cabang_id')->nullable()->after('id')->constrained('cabangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseps', function (Blueprint $table) {
            $table->dropForeign(['cabang_id']);
            $table->dropColumn('cabang_id');
        });
    }
};
