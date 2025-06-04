<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    //
    protected $table = 'izins';
    protected $fillable =[
         'karyawan_id',
        'name',
        'tanggal_pengajuan',
        'tanggal_izin',
        'tanggal_berakhir_izin',
        'keterangan',
        'status'
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id'); //
    }
}

