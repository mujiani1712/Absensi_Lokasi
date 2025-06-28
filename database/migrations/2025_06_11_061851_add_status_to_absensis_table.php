<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Tambahkan kolom 'status' jika belum ada
            if (!Schema::hasColumn('absensis', 'status')) {
                $table->string('status')->default('hadir')->after('jam');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Hapus kolom 'status' saat rollback
            if (Schema::hasColumn('absensis', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
