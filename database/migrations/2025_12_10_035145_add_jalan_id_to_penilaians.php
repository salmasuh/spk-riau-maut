<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // jika kolom belum ada, tambahkan
            if (!Schema::hasColumn('penilaians', 'jalan_id')) {
                // tambahkan sebagai foreignId nullable dulu (agar tidak memutus data existing)
                $table->foreignId('jalan_id')->nullable()->constrained('jalans')->nullOnDelete()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            if (Schema::hasColumn('penilaians', 'jalan_id')) {
                // drop foreign key constraint dulu bila ada
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                // safe drop: Laravel will handle if constraint name standar
                $table->dropForeign(['jalan_id']);
                $table->dropColumn('jalan_id');
            }
        });
    }
};