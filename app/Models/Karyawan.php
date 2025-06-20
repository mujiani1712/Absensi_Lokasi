<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Karyawan extends Model
{
    
     use HasFactory;
    protected $table = 'karyawans';
     protected $fillable =[
        'user_id',
        'name',
        'email',
        'password'
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public function absensi()
{
    //return $this->hasMany(Absensi::class, 'user_id');// PKAI
    return $this->hasMany(Absensi::class, 'karyawan_id', 'id');
}


public function izin()
{
    //return $this->hasMany(Absensi::class, 'user_id'); // PKAI
    return $this->hasMany(izin::class, 'karyawan_id', 'id');
}
    
    
   
}


