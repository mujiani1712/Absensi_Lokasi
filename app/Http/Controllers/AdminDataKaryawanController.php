<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminDataKaryawanController extends Controller
{
     public function index()
    {
      // $karyawans = Karyawan::all(); 
         $karyawans = Karyawan::with('user')->get();
    return view('admin.dataKaryawan.index', compact('karyawans'));
    }

    
        public function create()
    {
         return view('admin.dataKaryawan.create');
        
    }
         

    
  public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'tanggal_daftar' => 'required|date',
            'tanggal_mulai' => 'required|date',
        ]);
        
        // Simpan ke tabel users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // default password
            'role' => 'karyawan',
        ]);
        

        // Simpan ke tabel karyawans
         $karyawan =  Karyawan::create([
             'user_id' => $user->id, //tmb
            'name' => $request->name,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'tanggal_daftar' => $request->tanggal_daftar,
            'tanggal_mulai' => $request->tanggal_mulai,
        ]);
          dd($karyawan); // ➜ Cek apakah data benar-benar tersimpan

          return redirect()->route('admin.dataKaryawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

}
