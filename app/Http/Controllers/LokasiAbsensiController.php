<?php

namespace App\Http\Controllers;

use App\Models\LokasiAbsensi;
use Illuminate\Http\Request;

class LokasiAbsensiController extends Controller
{
    public function index()
    {
        $lokasis = LokasiAbsensi::all();
        return view('admin.lokasiabsensi', compact('lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        try {
            // Menambahkan lokasi baru
            LokasiAbsensi::create([
                'nama_toko' => $request->nama_toko,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
            ]);

             LokasiAbsensi::create($request->all());

            return redirect()->route('admin.lokasiabsensi')->with('success', 'Lokasi absensi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.lokasiabsensi')->with('error', 'Gagal menambahkan lokasi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $lokasi = LokasiAbsensi::findOrFail($id);
        return view('admin.editLokasiAbsensi', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        try {
            $lokasi = LokasiAbsensi::findOrFail($id);
            $lokasi->update([
                'nama_toko' => $request->nama_toko,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
            ]);

            return redirect()->route('admin.lokasiabsensi')->with('success', 'Lokasi absensi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.lokasiabsensi')->with('error', 'Gagal memperbarui lokasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $lokasi = LokasiAbsensi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('admin.lokasiabsensi')->with('success', 'Lokasi berhasil dihapus.');
    }
}
