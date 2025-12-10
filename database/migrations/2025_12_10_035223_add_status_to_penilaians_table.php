<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // jika menggunakan MySQL modern, enum boleh dipakai; kalau mau lebih portable pakai string
            if (! Schema::hasColumn('penilaians', 'status')) {
                // opsi: enum dengan default 'draft'
                $table->enum('status', ['draft','submitted'])->default('draft')->after('id');
                // atau alternatif: $table->string('status', 20)->default('draft')->after('nilai_kriteria');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            if (Schema::hasColumn('penilaians', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};