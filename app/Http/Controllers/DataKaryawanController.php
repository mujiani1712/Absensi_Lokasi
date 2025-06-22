<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class DataKaryawanController extends Controller
{
    public function index()
    {
        // baru di tmbhkan 
        $karyawans = Karyawan::with('user')->get();

        //$karyawans = Karyawan::all();
        //dd($karyawans); // debug
    return view('admin.dataKaryawan', compact('karyawans'));
    }


    public function store(Request $request)
{
    

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed', // form butuh input password dan konfirmasi baru ditambhkn
        'no_telp' => 'required|string',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
        'tanggal_masuk' => 'required|date',
    ]);

    // 1. Buat user akun login
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        //barudtmbhkn
        'no_telp' => $request->no_telp,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'tanggal_masuk' => $request->tanggal_masuk,
        'role' => 'karyawan'
    ]);

    // 2. Buat data karyawan dan hubungkan ke user
    // Simpan ke tabel karyawans, hubungkan ke user_id
    Karyawan::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'no_telp' => $user->no_telp,
        'jenis_kelamin' => $user->jenis_kelamin,
        'tanggal_lahir' => $user->tanggal_lahir,
        'alamat' => $user->alamat,
        'tanggal_masuk' => $user->tanggal_masuk,
    ]);
    return redirect()->route('admin.dataKaryawan')->with('success', 'Karyawan berhasil ditambahkan!');
}
}
