<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriasTable extends Migration
{
    public function up()
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                 // nama kriteria
            $table->text('deskripsi')->nullable();  // deskripsi
            $table->decimal('bobot', 5, 4)->default(0.0000); // bobot 0.0000 - 1.0000
            $table->enum('tipe', ['benefit','cost'])->default('benefit');
            $table->enum('status', ['aktif','tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kriterias');
    }
}