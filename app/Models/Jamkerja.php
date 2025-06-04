<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamkerja extends Model
{
    //
     protected $table = 'jam_kerjas';
     protected  $fillable = [
        'jam_masuk',
        'jam_pulang',
        'batas_terlambat'
     ];

}
