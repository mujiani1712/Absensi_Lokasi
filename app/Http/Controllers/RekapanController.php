<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Carbon\Carbon;

class RekapanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $search = $request->input('search');

        $karyawans = Karyawan::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $absen = [];

        // Tentukan daftar tanggal
        if ($tanggal) {
            $tanggalList = collect([Carbon::parse($tanggal)]);
        } else {
            $tanggalAwal = Carbon::now()->startOfMonth();
            $tanggalAkhir = Carbon::today(); // sampai hari ini
            $tanggalList = collect();

            for ($tgl = $tanggalAwal; $tgl->lte($tanggalAkhir); $tgl->addDay()) {
                if ($tgl->isSunday()) continue; // lewati hari Minggu
                $tanggalList->push($tgl->copy());
            }
        }

        // Looping tanggal dan karyawan
        foreach ($tanggalList as $tgl) {
            foreach ($karyawans as $karyawan) {
                if (!$karyawan->tanggal_masuk || Carbon::parse($karyawan->tanggal_masuk)->gt($tgl)) {
                    continue;
                }

                $absensis = $karyawan->absensi()->whereDate('created_at', $tgl->toDateString())->get();
                $masuk = $absensis->firstWhere('tipe', 'masuk');
                $pulang = $absensis->firstWhere('tipe', 'pulang');

                $izin = $karyawan->izin()
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_izin', '<=', $tgl->toDateString())
                    ->whereDate('tanggal_berakhir_izin', '>=', $tgl->toDateString())
                    ->first();

                if ($masuk && $pulang) {
                    $status = 'Hadir';
                } elseif ($masuk && !$pulang) {
                    $status = 'Belum Absen Pulang';
                } elseif ($izin) {
                    $status = 'Hadir (Izin Disetujui)';
                } else {
                    $status = 'Alpha';
                }

                $absen[] = [
                    'tanggal'      => $tgl->toDateString(),
                    'nama'         => $karyawan->name,
                    'jam_masuk'    => $masuk->jam ?? '-',
                    'foto_masuk'   => $masuk->foto ?? null,
                    'jam_pulang'   => $pulang->jam ?? '-',
                    'foto_pulang'  => $pulang->foto ?? null,
                    'keterangan'   => $izin?->keterangan ?? '-',
                    'lampiran'     => $izin?->lampiran ?? null,
                    'status'       => $status,
                ];
            }
        }

        return view('admin.rekapan', compact('absen', 'tanggal', 'search'));
    }
}
