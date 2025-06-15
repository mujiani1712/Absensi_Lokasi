<?php

/*
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Jamkerja;
use App\Models\LokasiAbsensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $absenMasuk = session('absenMasuk');
        $absenPulang = session('absenPulang');

        $karyawanId = Auth::id();
        $absensi_terakhir = Absensi::where('karyawan_id', $karyawanId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.absensi', compact('absenMasuk', 'absenPulang', 'absensi_terakhir'));
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,pulang',
            'foto' => 'required',
            'lokasi' => 'required',
            'jam' => 'required',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()->route('karyawan.absensi')->with('error', 'Karyawan tidak ditemukan.');
        }

        $lokasiToko = LokasiAbsensi::first();
        if (!$lokasiToko) {
            return redirect()->route('karyawan.absensi')->with('error', 'Lokasi kantor belum diatur oleh admin.');
        }

        list($latKaryawan, $lonKaryawan) = explode(',', $request->lokasi);

        $jarak = $this->hitungJarak(
            round($latKaryawan, 7),
            round($lonKaryawan, 7),
            round($lokasiToko->latitude, 7),
            round($lokasiToko->longitude, 7)
        );

        Log::info("Lat Karyawan: $latKaryawan, Lon: $lonKaryawan");
        Log::info("Lat Toko: {$lokasiToko->latitude}, Lon: {$lokasiToko->longitude}");
        Log::info("Jarak: $jarak meter (Radius diizinkan: {$lokasiToko->radius} meter)");

        if ($jarak > $lokasiToko->radius) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Anda berada di luar area absensi (' . round($jarak) . ' meter dari kantor).');
        }

        $jamkerja = Jamkerja::first();
        $jamSekarang = Carbon::parse($request->jam);
        $tipe = $request->tipe;

        if (!$jamkerja) {
            return redirect()->route('karyawan.riwayat')->with('error', 'Jam kerja belum diatur oleh admin.');
        }

        $sudahAbsenMasuk = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('tipe', 'masuk')
            ->exists();

        if ($tipe === 'masuk') {
            $batasTerlambat = Carbon::parse($jamkerja->batas_terlambat);

            if ($jamSekarang->gt($batasTerlambat)) {
                return redirect()->route('karyawan.riwayat')
                    ->with('error', 'Absen masuk ditolak. Anda terlambat (lebih dari jam ' . $batasTerlambat->format('H:i') . ').');
            }

            if ($sudahAbsenMasuk) {
                return redirect()->route('karyawan.riwayat')
                    ->with('error', 'Anda sudah melakukan absen masuk hari ini.');
            }
        }

        if ($tipe === 'pulang') {
            if (!$sudahAbsenMasuk) {
                return redirect()->route('karyawan.riwayat')
                    ->with('error', 'Tidak bisa absen pulang sebelum absen masuk.');
            }

            $sudahAbsenPulang = Absensi::where('karyawan_id', $karyawan->id)
                ->whereDate('created_at', Carbon::today())
                ->where('tipe', 'pulang')
                ->exists();

            if ($sudahAbsenPulang) {
                return redirect()->route('karyawan.riwayat')
                    ->with('error', 'Anda sudah absen pulang hari ini.');
            }

            $jamPulangMinimal = Carbon::parse($jamkerja->jam_pulang);
            if ($jamSekarang->lt($jamPulangMinimal)) {
                return redirect()->route('karyawan.riwayat')
                    ->with('error', 'Belum saatnya absen pulang. Minimal jam ' . $jamPulangMinimal->format('H:i') . '.');
            }
        }

        // Simpan foto dari base64
        $folderPath = public_path('uploads/foto_absen');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0775, true);
        }

        $image_parts = explode("base64,", $request->foto);
        $image_base64 = base64_decode($image_parts[1]);
        $filename = uniqid() . '.png';
        $filePath = $folderPath . '/' . $filename;
        file_put_contents($filePath, $image_base64);
        $publicPath = 'uploads/foto_absen/' . $filename;

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'name' => $karyawan->name,
            'tipe' => $tipe,
            'foto' => $publicPath,
            'lokasi' => $request->lokasi,
            'jam' => $request->jam,
            'status' => $request->status ?? 'hadir',
        ]);

        session(['absen' . ucfirst($tipe) => [
            'name' => $karyawan->name,
            'tipe' => $tipe,
            'foto' => asset($publicPath),
            'lokasi' => $request->lokasi,
            'jam' => $request->jam,
            'status' => $request->status ?? 'hadir',
        ]]);

        return redirect()->route('karyawan.riwayat')->with('success', 'Absensi berhasil disimpan!');
    }

    public function riwayat()
    {
        $karyawanId = Auth::id();
        $absensi_terakhir = Absensi::where('karyawan_id', $karyawanId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.riwayat', compact('absensi_terakhir'));
    }
}
*/



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absensi;
use App\Models\Jamkerja;
use App\Models\LokasiAbsensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
 

class AbsensiController extends Controller
{
    public function index()
    {
        $absenMasuk = session('absenMasuk');
        $absenPulang = session('absenPulang');

        $karyawanId = Auth::id();
        $absensi_terakhir = Absensi::where('karyawan_id', $karyawanId)
         ->orderBy('created_at', 'desc')
            ->get();
        return view('karyawan.absensi', compact('absenMasuk', 'absenPulang', 'absensi_terakhir'));
    }
    
    /*
    //tmb menghitung jarak BNR
    function hitungJarak($lat1, $lon1, $lat2, $lon2) {
   
        $meterPerDegree = 111320;
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;
        // Jarak dalam meter
        $jarak = sqrt(pow($dLat * $meterPerDegree, 2) + pow($dLon * $meterPerDegree, 2));
        return $jarak;
    }
    */

    //baru di tmba
    function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {   
        $earthRadius = 6371000; // meter
        $latFrom = deg2rad( $lat1);
        $lonFrom = deg2rad( $lon1);
        $latTo = deg2rad( $lat2);
        $lonTo = deg2rad( $lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
    }


    public function store(Request $request) {
    $request->validate([
        'tipe' => 'required|in:masuk,pulang',        
        'foto' => 'required', // Base64 image      
        'lokasi' => 'required',                    
        'jam' => 'required',  
       // 'status' => 'required',  
    ]);


    $user = Auth::user(); 
    $karyawan = $user->karyawan;

   // $karyawan = Auth::karyawan();
    if (!$karyawan) {
        return redirect()->route('karyawan.absensi')->with('error', 'Karyawan tidak ditemukan.');
    }

    
    //cek lokasi dari data absen  tmb
    $lokasiToko = LokasiAbsensi::first();
    if (!$lokasiToko){
        return redirect()->route('karyawan.absensi')->with('error','lokasi tokoh belum  di atur oleh admin');
    }

    /*
    //ambil koordinat dari request bnr
    list($latKaryawan, $lonKaryawan)= explode(',', $request->lokasi);
    
    //dari db
    $latToko = $lokasiToko->latitude;
    $lonToko = $lokasiToko->longitude;
    $radiusToko = $lokasiToko->radius;
    
    //hitung jarak
    $jarak = $this->hitungJarak($latKaryawan, $lonKaryawan, $latToko, $lonToko);
    */
    

    //bru di tmba
    list($latKaryawan, $lonKaryawan) = explode(',', $request->lokasi);

    // dari db
    $latToko = $lokasiToko->latitude;
    $lonToko = $lokasiToko->longitude;
    $radiusToko = $lokasiToko->radius;

    // Konversi ke float & bulatkan untuk akurasi
    $latKaryawan = round( $latKaryawan, 7);
    $lonKaryawan = round( $lonKaryawan, 7);
    $latToko = round( $latToko, 7);
    $lonToko = round( $lonToko, 7);

    // hitung jarak
    $jarak = $this->hitungJarak($latKaryawan, $lonKaryawan, $latToko, $lonToko);



    // Logging jarak dan koordinat
        Log::info("Lat karyawan: $latKaryawan");
        Log::info("Lon karyawan: $lonKaryawan");
        Log::info("Lat toko: $latToko");
        Log::info("Lon toko: $lonToko");
        Log::info("Jarak dihitung: $jarak, Radius toko: $radiusToko");

    if ($jarak > $radiusToko){
        // return redirect()->route('account.absensi')->with('error', 'Anda berada di luar area absensi (' . round($jarak) . ' meter dari toko).');
         return redirect()->route('karyawan.riwayat')->with('error', 'Anda berada di luar area absensi (' . round($jarak) . ' meter dari kantor).');
    }

       /*
      
    $jamkerja = Jamkerja::first(); // ambil setting jam kerja
    $jamSekarang = Carbon::now();
     $tipe = $request->input('tipe');
    
    if ($jamkerja && $tipe === 'masuk') {
        $batasTerlambat = Carbon::parse($jamkerja->batas_terlambat);

        if ($jamSekarang->gt($batasTerlambat)) {
            return redirect()->route('karyawan.riwayat')->with('error', 'Absen masuk ditolak. Anda terlambat masuk (lebih dari jam ' . $batasTerlambat->format('H:i') . ').');
        }
    }
    
    


 
    //MENGATUR WAKTU
    $tipe = $request->tipe;
    $jamSekarang = Carbon::parse($request->jam);

    // Cek apakah user sudah absen masuk hari ini
    $sudahAbsenMasuk = Absensi::where('karyawan_id', $karyawan->id)
        ->whereDate('created_at', Carbon::today())
        ->where('tipe', 'masuk')
        ->exists();

    if ($tipe === 'masuk') {
        if ($jamSekarang->gt(Carbon::createFromTime(10, 0))) {
            return redirect()->route('account.riwayat')->with('error', 'Absen masuk ditolak. Anda terlambat masuk (lebih dari jam 10:00).');
        }

        if ($sudahAbsenMasuk) {
            return redirect()->route('account.riwayat')->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }
    }

    if ($tipe === 'pulang') {
        if (!$sudahAbsenMasuk) {
            return redirect()->route('account.riwayat')->with('error', 'Anda belum absen masuk, tidak bisa absen pulang.');
        }

        // Cek apakah sudah absen pulang
        $sudahAbsenPulang = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('tipe', 'pulang')
            ->exists();

        if ($sudahAbsenPulang) {
            return redirect()->route('account.riwayat')->with('error', 'Anda sudah absen pulang hari ini.');
        }
    }
    */


        
    $jamkerja = Jamkerja::first(); 
    //$jamSekarang = Carbon::now();
    $jamSekarang = Carbon::parse($request->jam); // ← GANTI INI
    $tipe = $request->input('tipe');

    $sudahAbsenMasuk = Absensi::where('karyawan_id', $karyawan->id)
        ->whereDate('created_at', Carbon::today())
        ->where('tipe', 'masuk')
        ->exists();

        if (!$jamkerja) {
    return redirect()->route('karyawan.riwayat')->with('error', 'Jam kerja belum diatur oleh admin.');
    }

    if ($tipe === 'masuk') {
        $batasTerlambat = Carbon::parse($jamkerja->batas_terlambat);

        if ($jamSekarang->gt($batasTerlambat)) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Absen masuk ditolak. Anda terlambat (lebih dari jam ' . $batasTerlambat->format('H:i') . ').');
        }

        if ($sudahAbsenMasuk) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }
    }

    if ($tipe === 'pulang') {
        if (!$sudahAbsenMasuk) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Tidak bisa absen pulang sebelum absen masuk.');
        }

        $sudahAbsenPulang = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('created_at', Carbon::today())
            ->where('tipe', 'pulang')
            ->exists();

        if ($sudahAbsenPulang) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Anda sudah absen pulang hari ini.');
        }

        $jamPulangMinimal = Carbon::parse($jamkerja->jam_pulang);
        if ($jamSekarang->lt($jamPulangMinimal)) {
            return redirect()->route('karyawan.riwayat')
                ->with('error', 'Belum saatnya absen pulang. Minimal jam ' . $jamPulangMinimal->format('H:i'));
        }
    }






    // Proses penyimpanan foto
    $folderPath = public_path('uploads/foto_absen');
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0775, true);
    }

    // Simpan foto dari base64
    $image_parts = explode("base64,", $request->foto);
    $image_base64 = base64_decode($image_parts[1]); 
    $filename = uniqid() . '.png';
    $filePath = $folderPath . '/' . $filename;
    file_put_contents($filePath, $image_base64);
    $publicPath = 'uploads/foto_absen/' . $filename;

    /*
    // Simpan data absensi bnr
    Absensi::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'tipe' => $request->tipe,
        'foto' => $publicPath,
        'lokasi' => $request->lokasi,
        'jam' => $request->jam,
    ]);
    */

    Absensi::create([
        'karyawan_id' => $karyawan->id,
        'name' => $karyawan->name,
        'tipe' => $request->tipe,
        'foto' => $publicPath,
        'lokasi' => $request->lokasi,
        'jam' => $request->jam,
       'status' => $request->status ?? 'hadir' //bru tmb
        
    ]);


    /*
    // Set data ke session bnr
    $absensData = [
        'name' => $user->name,
        'tipe' => $request->tipe,
        'foto' => asset('uploads/foto_absen/' . $filename),
        'lokasi' => $request->lokasi,
        'jam' => $request->jam,
    ];
    */

     $absensData = [
        'name' => $karyawan->name,
        'tipe' => $request->tipe,
        'foto' => asset('uploads/foto_absen/' . $filename),
        'lokasi' => $request->lokasi,
        'jam' => $request->jam,
       'status' => $request->status ?? 'hadir' //tmb
    ];

    //session(['absen' => $absensData]);
    session(['absen' . ucfirst($request->tipe) => $absensData]);

    /*
    if ($request->tipe === 'masuk') {
        session(['absenMasuk' => $absensData]);
    } elseif ($request->tipe === 'pulang') {
        session(['absenPulang' => $absensData]);
    } */
    return redirect()->route('karyawan.riwayat')->with('success', 'Absensi berhasil disimpan!');
    
}

/*
//tmb bnr
public function riwayat(){
    $userId = Auth::id();
    $absensi_terakhir = Absensi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
          // ->paginate(10);
            ->get();
        return view ('riwayat', compact('absensi_terakhir'));

}
*/

public function riwayat(){
    $loggedInId = Auth::id();
    //dd('Auth::id() = '.$loggedInId);

    $karyawanId = Auth::id(); // bnr
   $absensi_terakhir = Absensi::where('karyawan_id', $karyawanId) 
              ->orderBy('created_at', 'desc')
          // ->paginate(10);
            ->get();

           // dd($absensi_terakhir);
        return view ('karyawan.riwayat', compact('absensi_terakhir'));

}
    
        
}
