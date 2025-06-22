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
            $table->date('periode'); 
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->integer('hadir')->default(0);
            $table->integer('alpha')->default(0);
            $table->integer('sakit')->default(0);
             $table->bigInteger('gaji_pokok')->default(3000000);
            $table->bigInteger('potongan')->default(0);
            $table->bigInteger('gaji_bersih');
            $table->timestamps();
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
