<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
     protected $fillable = [
        'periode',
        'karyawan_id',
        'hadir',
        'alpha',
        'sakit',
        'gaji_pokok',
        'potongan',
        'gaji_bersih',
    ];

    public function karyawan()
        {
            return $this->belongsTo(Karyawan::class);
        }
}
