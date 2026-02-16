<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            $table->string('nama_jalan_lower')
                ->storedAs('LOWER(nama_jalan)')
                ->unique()
                ->after('nama_jalan');
        });
    }

    public function down(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            $table->dropUnique(['nama_jalan_lower']);
            $table->dropColumn('nama_jalan_lower');
        });
    }
};