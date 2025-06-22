<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Carbon\Carbon;
class RekapanController extends Controller
{
    //

  
    /*
public function index(Request $request)
{
    $tanggal = $request->input('tanggal') ?? date('Y-m-d');

    $karyawans = Karyawan::all();

    $absen = [];

    foreach ($karyawans as $karyawan) {
        $absensiHariIni = $karyawan->absensi()
            ->whereDate('created_at', $tanggal)
            ->get();

        $absenMasuk = $absensiHariIni->firstWhere('tipe', 'masuk');
        $absenPulang = $absensiHariIni->firstWhere('tipe', 'pulang');

        $absen[] = [
            'nama' => $karyawan->name,
            'tanggal' => $tanggal,
            'jam_masuk' => $absenMasuk->jam ?? '-',
            'foto_masuk' => $absenMasuk->foto ?? null,
            'jam_pulang' => $absenPulang->jam ?? '-',
            'foto_pulang' => $absenPulang->foto ?? null,
            'status' => $absenMasuk ? $absenMasuk->status : 'Alpha',
        ];
    }

    return view('admin.rekapan', compact('absen', 'tanggal'));
}
*/

/*
public function index(Request $request)
{
    $tanggalAwal = Carbon::now()->startOfMonth();
    $tanggalAkhir = Carbon::now()->startOfDay(); // hanya sampai hari ini

    $karyawans = Karyawan::all();
    $absen = [];

    for ($tanggal = $tanggalAwal->copy(); $tanggal->lte($tanggalAkhir); $tanggal->addDay()) {
        foreach ($karyawans as $karyawan) {
            $absensi = $karyawan->absensi()
                ->whereDate('created_at', $tanggal->toDateString())
                ->where('tipe', 'masuk')
                ->first();

            $absen[] = [
                'tanggal' => $tanggal->toDateString(),
                'nama' => $karyawan->name,
                'jam_masuk' => $absenMasuk->jam ?? '-',
                'foto_masuk' => $absenMasuk->foto ?? null,
                'jam_pulang' => $absenPulang->jam ?? '-',
                'foto_pulang' => $absenPulang->foto ?? null,
                'status' => $absensi ? 'Hadir' : 'Alpha',
            ];
        }
    }

    return view('admin.rekapan', compact('absen','tanggal'));
}
*/

 
/* JAD
    public function index(Request $request)
{
    
    $tanggalAwal = Carbon::now()->startOfMonth();
    $tanggalAkhir = Carbon::now()->startOfDay();

    $karyawans = Karyawan::all();
    $absen = [];

    for ($tanggal = $tanggalAwal->copy(); $tanggal->lte($tanggalAkhir); $tanggal->addDay()) {
        foreach ($karyawans as $karyawan) {
            // Ambil semua absensi tanggal ini
            $absensis = $karyawan->absensi()
                ->whereDate('created_at', $tanggal->toDateString())
                ->get();

            $absenMasuk = $absensis->firstWhere('tipe', 'masuk');
            $absenPulang = $absensis->firstWhere('tipe', 'pulang');

            $absen[] = [
                'tanggal' => $tanggal->toDateString(),
                'nama' => $karyawan->name,
                'jam_masuk' => $absenMasuk->jam ?? '-',
                'foto_masuk' => $absenMasuk->foto ?? null,
                'jam_pulang' => $absenPulang->jam ?? '-',
                'foto_pulang' => $absenPulang->foto ?? null,
                'status' => $absenMasuk ? $absenMasuk->status : 'Alpha',
            ];
        }
    }

    return view('admin.rekapan', compact('absen','tanggal'));
}
*/


/* st
    public function index(Request $request)
{
    $tanggal = $request->input('tanggal');
    $karyawans = Karyawan::all();
    $absen = [];

    if ($tanggal) {
        // Jika cari tanggal tertentu
        $tanggalList = [Carbon::parse($tanggal)];
    } else {
        // Jika tidak pilih tanggal, ambil semua dari awal bulan sampai hari ini
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->startOfDay();
        $tanggalList = [];

        for ($tgl = $tanggalAwal; $tgl->lte($tanggalAkhir); $tgl->addDay()) {
            $tanggalList[] = $tgl->copy();
        }
    }

    foreach ($tanggalList as $tgl) {
        foreach ($karyawans as $karyawan) {
            $absensis = $karyawan->absensi()->whereDate('created_at', $tgl->toDateString())->get();
            $masuk = $absensis->firstWhere('tipe', 'masuk');
            $pulang = $absensis->firstWhere('tipe', 'pulang');

            
            
            $absen[] = [
                'tanggal' => $tgl->toDateString(),
                'nama' => $karyawan->name,
                'jam_masuk' => $masuk->jam ?? '-',
                'foto_masuk' => $masuk->foto ?? null,
                'jam_pulang' => $pulang->jam ?? '-',
                'foto_pulang' => $pulang->foto ?? null,
                'status' => $masuk->status ?? 'Alpha',
            ];
        }
    }

    return view('admin.rekapan', compact('absen', 'tanggal'));
}

*/



public function index(Request $request)
{
    $tanggal = $request->input('tanggal');
    $karyawans = Karyawan::all();
    $absen = [];

    if ($tanggal) {
        // Jika cari tanggal tertentu
        $tanggalList = [Carbon::parse($tanggal)];
    } else {
        // Jika tidak pilih tanggal, ambil semua dari awal bulan sampai hari ini
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->startOfDay();
        $tanggalList = [];

        for ($tgl = $tanggalAwal; $tgl->lte($tanggalAkhir); $tgl->addDay()) {
            $tanggalList[] = $tgl->copy();
        }
    }

    foreach ($tanggalList as $tgl) {
        foreach ($karyawans as $karyawan) {

            // 👉 Lewati tanggal sebelum karyawan mulai kerja
        if ($karyawan->tanggal_mulai && $tgl->lt(Carbon::parse($karyawan->tanggal_mulai))) {
            continue;
        }


            $absensis = $karyawan->absensi()
                ->whereDate('created_at', $tgl->toDateString())
                ->get();

            $masuk = $absensis->firstWhere('tipe', 'masuk');
            $pulang = $absensis->firstWhere('tipe', 'pulang');

            // Penentuan status:
            $status = 'Alpha';
            if ($masuk && $pulang) {
                $status = 'Hadir';
            } elseif ($masuk && !$pulang) {
                $status = 'Belum Pulang';
            }

            $absen[] = [
                'tanggal' => $tgl->toDateString(),
                'nama' => $karyawan->name,
                'jam_masuk' => $masuk->jam ?? '-',
                'foto_masuk' => $masuk->foto ?? null,
                'jam_pulang' => $pulang->jam ?? '-',
                'foto_pulang' => $pulang->foto ?? null,
                'status' => $status,
            ];
        }
    }

    return view('admin.rekapan', compact('absen', 'tanggal'));
}
    

}

