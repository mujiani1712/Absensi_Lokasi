<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiAbsensi extends Model
{
    //
      protected $table = 'lokasi_absensis';
     

     protected $fillable = ['nama_toko', 'latitude', 'longitude', 'radius'];
}
