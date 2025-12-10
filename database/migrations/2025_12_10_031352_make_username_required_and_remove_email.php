<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Pastikan kolom username ada; jika belum, buat
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            } else {
                // jika ada tapi nullable / belum unique, ubah
                $table->string('username')->nullable(false)->change();
                // unique index mungkin perlu ditambahkan
                $table->unique('username');
            }
        });

        // 2) Hapus kolom email jika ada (bergerak hati-hati: drop index dulu)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) {
                // drop unique index kalau ada
                try {
                    $table->dropUnique(['email']);
                } catch (\Throwable $e) {
                    // index mungkin punya nama lain, fallback ke raw SQL safe try
                    // ignore
                }
                $table->dropColumn('email');
            }
        });

        // jika ada tabel lain bergantung ke email, pastikan diperiksa manual.
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('username');
            }
            if (Schema::hasColumn('users', 'username')) {
                try {
                    $table->dropUnique(['username']);
                } catch (\Throwable $e) {}
                // keep username column when rollback? we keep it.
            }
        });
    }
};