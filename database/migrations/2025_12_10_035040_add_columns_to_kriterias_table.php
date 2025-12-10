<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            if (!Schema::hasColumn('kriterias', 'bobot')) {
                $table->decimal('bobot', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('kriterias', 'tipe')) {
                $table->enum('tipe', ['benefit', 'cost'])->default('benefit');
            }
            if (!Schema::hasColumn('kriterias', 'status')) {
                $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            $table->dropColumn(['bobot', 'tipe', 'status']);
        });
    }
};