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
        Schema::create('lokasi_absensis', function (Blueprint $table) {
            $table->id();

            $table->string('nama_toko');
            $table->decimal('latitude', 10,7);
             $table->decimal('longitude', 10,7);
             $table->integer('radius');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_absensis');
    }
};
