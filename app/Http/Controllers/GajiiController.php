<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\Karyawan;
use Carbon\Carbon;

class GajiiController extends Controller
{
    public function index()
    {
        $dataGaji = Gaji::all(); // ambil dari database jika ada
        // return view('admin.gaji', compact('dataGaji'));
    }

    public function gaji()
    {
        $karyawans = Karyawan::all();
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->endOfMonth();
        $tanggalList = [];

        for ($tgl = $tanggalAwal->copy(); $tgl->lte($tanggalAkhir); $tgl->addDay()) {
            $tanggalList[] = $tgl->toDateString();
        }

        $gajiData = [];

        foreach ($karyawans as $karyawan) {
            $hadir = 0;
            $alpha = 0;

            foreach ($tanggalList as $tanggal) {
                //$absenMasuk = $karyawan->absensi()->whereDate('created_at', $tanggal)->first();
                $absen = $karyawan->absensi()->whereDate('created_at', $tanggal)->first();

                $izin = $karyawan->izin()
                    ->whereDate('tanggal_izin', '<=', $tanggal)
                    ->whereDate('tanggal_berakhir_izin', '>=', $tanggal)
                    ->exists();

               /* if ($absenMasuk || $izin) {
                    $hadir++;
                } else {
                    $alpha++;
                }*/
                // bru ditmbhkn
                if ($absen && $absen->jam_masuk && $absen->jam_pulang) {
                    $hadir++;
                } elseif ($izin) {
                     $hadir++;
                } else {
                     $alpha++;
        }
            }

            $gajiPokok = 3000000;
            $potongan = $alpha * 100000;
            $gajiBersih = $gajiPokok - $potongan;

            $gajiData[] = [
                'nama' => $karyawan->name,
                'hadir' => $hadir,
                'alpha' => $alpha,
                'gaji_pokok' => $gajiPokok,
                'potongan' => $potongan,
                'gaji_bersih' => $gajiBersih,
            ];
        }

        return view('admin.gaji', compact('gajiData'));
    }
}
