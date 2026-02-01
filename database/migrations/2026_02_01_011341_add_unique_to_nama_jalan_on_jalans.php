<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            // pastikan belum ada index unik sebelumnya
            $table->unique('nama_jalan');
        });
    }

    public function down(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            $table->dropUnique(['nama_jalan']);
        });
    }
};