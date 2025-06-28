<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Carbon\Carbon;

class GajiiController extends Controller
{
    public function gaji()
    {
        $karyawans = Karyawan::all();
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::today();

        $gajiData = [];

        foreach ($karyawans as $karyawan) {
            $hadir = 0;
            $alpha = 0;

            if (!$karyawan->tanggal_masuk) {
                continue;
            }

            try {
                $tanggalMulaiKerja = Carbon::parse($karyawan->tanggal_masuk);
            } catch (\Exception $e) {
                continue;
            }

            $awalHitung = $tanggalMulaiKerja->gt($tanggalAwal) ? $tanggalMulaiKerja : $tanggalAwal;

            $tanggalList = collect();
            for ($tgl = $awalHitung->copy(); $tgl->lte($tanggalAkhir); $tgl->addDay()) {
                if (!$tgl->isSunday()) { // hanya hari kerja (Senin-Sabtu)
                    $tanggalList->push($tgl->copy());
                }
            }

            $hariKerja = $tanggalList->count();

            foreach ($tanggalList as $tgl) {
                $absensis = $karyawan->absensi()
                    ->whereDate('created_at', $tgl->toDateString())
                    ->get();

                $absenMasuk = $absensis->firstWhere('tipe', 'masuk');
                $absenPulang = $absensis->firstWhere('tipe', 'pulang');

                $izinDisetujui = $karyawan->izin()
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_izin', '<=', $tgl->toDateString())
                    ->whereDate('tanggal_berakhir_izin', '>=', $tgl->toDateString())
                    ->exists();

                if (($absenMasuk && $absenPulang) || $izinDisetujui) {
                    $hadir++;
                } elseif ($absenMasuk && !$absenPulang) {
                    $alpha++;
                } else {
                    $alpha++;
                }
            }

            $gajiPokok = 2000000;
            $gajiHarian = 80000; // Tetapkan gaji harian tetap Rp80.000
$gajiKotor = $hadir * $gajiHarian;
$potongan = $alpha * 50000;
$gajiBersih = $gajiKotor - $potongan;


            $gajiData[] = [
                'nama' => $karyawan->name,
                'hadir' => $hadir,
                'alpha' => $alpha,
                'hari_kerja' => $hariKerja,
                'gaji_pokok' => $gajiPokok,
                'gaji_harian' => round($gajiHarian),
                'potongan' => $potongan,
                'gaji_bersih' => round($gajiBersih),
            ];
        }

        return view('admin.gaji', compact('gajiData'));
    }
}
