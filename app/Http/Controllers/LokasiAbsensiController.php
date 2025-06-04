<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LokasiAbsensi;
use Illuminate\Http\Request;
use Illuminate\Log;

class LokasiAbsensiController extends Controller
{
    //
    public function index(){
        //return view('admin.lokasiabsensi');
        # $users = User::userr()->get();
    $lokasi = LokasiAbsensi::first();
    return view('admin.lokasiabsensi', compact('lokasi'));
    }

   public function update(Request $request)
{
    $request->validate([
        'nama_toko' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'radius' => 'required|numeric',
    ]);

    try {
        LokasiAbsensi::updateOrCreate(['id' => 1], [
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()->route('admin.lokasiabsensi')->with('success', 'Lokasi absensi berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->route('admin.lokasiabsensi')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
}

}


