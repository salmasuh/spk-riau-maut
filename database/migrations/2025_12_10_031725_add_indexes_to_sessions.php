<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Cek apakah kolom tersedia
            if (Schema::hasColumn('sessions', 'last_activity')) {
                // Cek sebelum buat index agar tidak duplikat
                if (!DB::select("SHOW INDEX FROM sessions WHERE Key_name = 'sessions_last_activity_index'")) {
                    $table->index('last_activity', 'sessions_last_activity_index');
                }
            }

            if (Schema::hasColumn('sessions', 'user_id')) {
                if (!DB::select("SHOW INDEX FROM sessions WHERE Key_name = 'sessions_user_id_index'")) {
                    $table->index('user_id', 'sessions_user_id_index');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Hapus index jika ada
            if (DB::select("SHOW INDEX FROM sessions WHERE Key_name = 'sessions_last_activity_index'")) {
                $table->dropIndex('sessions_last_activity_index');
            }

            if (DB::select("SHOW INDEX FROM sessions WHERE Key_name = 'sessions_user_id_index'")) {
                $table->dropIndex('sessions_user_id_index');
            }
        });
    }
};