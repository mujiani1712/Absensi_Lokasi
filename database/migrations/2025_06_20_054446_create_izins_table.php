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
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
              $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->string('name');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_izin');
            $table->date('tanggal_berakhir_izin');
            $table->string('keterangan'  );
            $table->string('lampiran')->nullable();
            $table->string('status')->default('pending'); // ✅ tambah default


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
