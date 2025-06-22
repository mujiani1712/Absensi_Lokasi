<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gaji;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class GajiController extends Controller
{
 

         public function index()
    {
        $periode = Carbon::now()->startOfMonth()->toDateString(); // default: bulan ini

        $data = Gaji::where('periode', $periode)->with('karyawan')->get();

        return view('admin.gaji', compact('data', 'periode'));
    }

    public function store(Request $request)
{
    $periode = Carbon::now()->startOfMonth()->toDateString(); 
    $karyawans = Karyawan::all();
    Gaji::where('periode', $periode)->delete();

    foreach ($karyawans as $karyawan) {
        $hadir = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->where('status', 'hadir')
                        ->count();

        $alpha = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->where('status', 'alpha')
                        ->count();

        $sakit = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->where('status', 'sakit')
                        ->count();

        // Hitung gaji
        $gaji_pokok = $karyawan->gaji_pokok ?? 0;
        $potongan = $alpha * 50000;
        $gaji_bersih = $gaji_pokok - $potongan;

        Gaji::create([
            'periode' => $periode,
            'karyawan_id' => $karyawan->id,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'sakit' => $sakit,
            'gaji_pokok' => $gaji_pokok,
            'potongan' => $potongan,
            'gaji_bersih' => $gaji_bersih,
        ]);
    }

    return redirect()->route('admin.gaji')->with('success', 'Gaji bulan ini berhasil dihitung.');
}



}
