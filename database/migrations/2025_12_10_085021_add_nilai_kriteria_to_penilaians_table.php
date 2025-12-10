<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->json('nilai_kriteria')->nullable();
        });
    }

    public function down()
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn('nilai_kriteria');
        });
    }

};
