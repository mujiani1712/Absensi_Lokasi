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
        Schema::table('karyawans', function (Blueprint $table) {
        
          
          $table->text('alamat')->nullable();
        $table->date('tanggal_daftar')->nullable();
        $table->date('tanggal_mulai')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
             $table->dropColumn('alamat');
            $table->dropColumn('tanggal_daftar');
            $table->dropColumn('tanggal_mulai');
        });
    }
};
