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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id'); // Relasi ke tabel karyawan
            $table->string('nama_karyawan');
            $table->integer('hadir');
            $table->integer('alpa');
            $table->decimal('gaji_pokok', 12, 2);
            $table->decimal('potongan_alpa', 12, 2);
            $table->decimal('gaji_bersih', 12, 2);
            $table->timestamps();

            // Foreign key jika tabel karyawans tersedia
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
