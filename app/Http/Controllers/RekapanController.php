<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Izin;
use Carbon\Carbon;
class RekapanController extends Controller
{
    public function index(Request $request)
{
    $tanggal = $request->input('tanggal');
    $search = $request->input('search'); // tambahkan ini

    // Ambil karyawan, filter jika ada pencarian nama
    $karyawans = Karyawan::query()
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->get();

    $absen = [];

    // Tentukan daftar tanggal
    if ($tanggal) {
        $tanggalList = [Carbon::parse($tanggal)];
    } else {
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->startOfDay();
        $tanggalList = [];

        for ($tgl = $tanggalAwal; $tgl->lte($tanggalAkhir); $tgl->addDay()) {
            $tanggalList[] = $tgl->copy();
        }
    }

    // Looping data absen
    foreach ($tanggalList as $tgl) {
        foreach ($karyawans as $karyawan) {
            $absensis = $karyawan->absensi()
                ->whereDate('created_at', $tgl->toDateString())
                ->get();

            $masuk = $absensis->firstWhere('tipe', 'masuk');
            $pulang = $absensis->firstWhere('tipe', 'pulang');

            $izin = $karyawan->izin()
                ->whereDate('tanggal_izin', '<=', $tgl->toDateString())
                ->whereDate('tanggal_berakhir_izin', '>=', $tgl->toDateString())
                ->first();

            if ($masuk && $pulang) {
                $status = 'Hadir';
            } elseif ($masuk && !$pulang) {
                $status = 'Belum Pulang';
            } elseif ($izin) {
                $status = 'Hadir';
            } else {
                $status = 'Alpha';
            }

            $absen[] = [
                'tanggal' => $tgl->toDateString(),
                'nama' => $karyawan->name,
                'jam_masuk' => $masuk->jam ?? '-',
                'foto_masuk' => $masuk->foto ?? null,
                'jam_pulang' => $pulang->jam ?? '-',
                'foto_pulang' => $pulang->foto ?? null,
                'keterangan' => $izin?->keterangan ?? '-',
                'lampiran' => $izin?->lampiran ?? null,
                'status' => $status,
            ];
        }
    }

    return view('admin.rekapan', compact('absen', 'tanggal', 'search'));
}

        // ✅ Tambahan fungsi untuk perhitungan gaji
    /*public function gaji()
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
            $absenMasuk = $karyawan->absensi()->whereDate('created_at', $tanggal)->first();
            $izin = $karyawan->izin()
                ->whereDate('tanggal_izin', '<=', $tanggal)
                ->whereDate('tanggal_berakhir_izin', '>=', $tanggal)
                ->exists();

            if ($absenMasuk || $izin) {
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
}*/

}



