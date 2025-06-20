<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis'; // Nama tabel di database

    protected $fillable = [
        'karyawan_id',
        'nama_karyawan',
        'hadir',
        'alpa',
        'gaji_pokok',
        'potongan_alpa',
        'gaji_bersih',
    ];

    // (Opsional) Relasi ke model Karyawan jika kamu punya model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
