<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            // pastikan kolom ada
            if (Schema::hasColumn('jalans', 'panjang')) {
                $table->decimal('panjang', 8, 2)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jalans', function (Blueprint $table) {
            // rollback ke DATE (opsional, jarang dipakai)
            if (Schema::hasColumn('jalans', 'panjang')) {
                $table->date('panjang')->change();
            }
        });
    }
};