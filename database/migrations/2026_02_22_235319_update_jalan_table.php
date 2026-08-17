<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jalans', function (Blueprint $table) {

            // 🔹 ganti nama kolom
            if (Schema::hasColumn('jalans', 'tanggal_input')) {
                $table->renameColumn('tanggal_input', 'panjang');
            }

            // 🔹 hapus kolom
            if (
                Schema::hasColumn('jalans', 'panjang_ruas') &&
                Schema::hasColumn('jalans', 'nama_jalan_lower')
            ) {
                $table->dropColumn(['panjang_ruas', 'nama_jalan_lower']);
            }

        });
    }

    public function down(): void
    {
        Schema::table('jalans', function (Blueprint $table) {

            // balikin nama kolom
            if (Schema::hasColumn('jalans', 'panjang')) {
                $table->renameColumn('panjang', 'tanggal_input');
            }

            // balikin kolom yang dihapus
           if (!Schema::hasColumn('jalans', 'panjang_ruas')) {
                $table->date('panjang_ruas')->nullable();
            }

            if (!Schema::hasColumn('jalans', 'nama_jalan_lower')) {
                $table->string('nama_jalan_lower', 100)->nullable();
            }

        });
    }
};
