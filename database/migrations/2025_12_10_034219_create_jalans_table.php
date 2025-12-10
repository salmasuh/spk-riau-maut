<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jalans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jalan');
            $table->string('kabupaten_kota');
            $table->enum('status',['Aktif','Tidak Aktif'])->default('Aktif');
            $table->date('tanggal_input')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalans');
    }
};