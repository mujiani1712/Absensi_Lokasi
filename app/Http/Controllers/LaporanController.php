<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Jamkerja;
use App\Models\Karyawan;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    //
     public function index()
    {
        //
        return view('admin.laporan');
    }

 public function laporanKehadiran()
{
    $jamkerja = Jamkerja::firstOrFail();
    $batasTerlambat = Carbon::parse($jamkerja->batas_terlambat);

    /*
    $tanggalAwal = now();
    $tanggalAkhir = now()->startOfDay();

    */
    $tanggalAwal = now()->startOfMonth(); // ✅ mulai dari tanggal 1
    $tanggalAkhir = now()->startOfDay();  // ✅ sampai hari ini

    
    $karyawans = Karyawan::all();

    $laporan = [];

    $periode = new \DatePeriod(
        $tanggalAwal,
        new \DateInterval('P1D'),
        $tanggalAkhir->copy()->addDay() // supaya inklusif sampai akhir
    );

    foreach ($periode as $tanggal) {
        foreach ($karyawans as $karyawan) {
            $absenMasuk = Absensi::where('karyawan_id', $karyawan->id)
                ->where('tipe', 'masuk')
                ->whereDate('created_at', $tanggal->format('Y-m-d'))
                ->first();

            $status = 'Alpha';
            if ($absenMasuk && Carbon::parse($absenMasuk->jam)->lte($batasTerlambat)) {
                $status = 'Hadir';
            }

            $laporan[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'nama' => $karyawan->name,
                'status' => $status,
            ];
        }
    }

    return view('admin.laporan', compact('laporan'));
}






// baru di tamba
public function laporanGaji()
{
    $tanggalAwal = now()->startOfMonth();
    $tanggalAkhir = now()->startOfDay();

    $jamkerja = Jamkerja::firstOrFail();
    $batasTerlambat = Carbon::parse($jamkerja->batas_terlambat);

    $karyawans = Karyawan::all();
    $periode = new \DatePeriod(
        $tanggalAwal,
        new \DateInterval('P1D'),
        $tanggalAkhir->copy()->addDay()
    );

    $dataGaji = [];

    foreach ($karyawans as $karyawan) {
        $alpha = 0;
        $hadir = 0;

        foreach ($periode as $tanggal) {
            $absenMasuk = Absensi::where('karyawan_id', $karyawan->id)
                ->where('tipe', 'masuk')
                ->whereDate('created_at', $tanggal->format('Y-m-d'))
                ->first();

            if ($absenMasuk && Carbon::parse($absenMasuk->jam)->lte($batasTerlambat)) {
                $hadir++;
            } else {
                $alpha++;
            }
        }

        $gajiPokok = 3000000; // bisa diubah ke database nanti
        $potongan = 100000 * $alpha;
        $gajiBersih = $gajiPokok - $potongan;

        $dataGaji[] = [
            'nama' => $karyawan->name,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'gaji_pokok' => $gajiPokok,
            'potongan' => $potongan,
            'gaji_bersih' => $gajiBersih,
        ];
    }

    return view('admin.gaji', compact('dataGaji'));
}


}
