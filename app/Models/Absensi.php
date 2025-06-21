<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    //
     protected $table = 'absensis'; 
        protected $fillable =[
        //'user_id', bnr
        'karyawan_id',
        'name',
        'tipe',
        'foto',
        'lokasi',
        'jam',
       'status'
    ];

    public function karyawan()
    {

       
       // return $this->belongsTo(Karyawan::class, 'user_id'); //pakai 
         
        return $this->belongsTo(Karyawan::class, 'karyawan_id'); //
    }

}
