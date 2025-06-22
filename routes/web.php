<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AprovalizinController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\LokasiAbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDataKaryawanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapanController;
use App\Http\Controllers\RiwayatController;
use App\Models\Gaji;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($user->role === 'karyawan') {
        return redirect('/karyawan/dashboard');
    }

    return redirect('/'); // default jika role lain atau tidak ada
})->middleware('auth')->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
 
    // route admin lainnya
    Route::get('/admin/lokasiabsensi', [LokasiAbsensiController::class, 'index'])->name('admin.lokasiabsensi');
    Route::post('/admin/lokasiabsensi', [LokasiAbsensiController::class, 'update'])->name('admin.lokasiabsensi');
    Route::get('/admin/rekapan', [RekapanController::class, 'index'])->name('admin.rekapan');
  
    
    Route::get('/admin/jamkerja', [JamKerjaController::class, 'index'])->name('admin.jamkerja');
    Route::post('admin/jamkerja/store', [JamkerjaController::class, 'store'])->name('admin.jamkerja.store');
   Route::delete('admin/jamkerja/destroy', [JamkerjaController::class, 'destroy'])->name('admin.jamkerja.destroy');

    //Route::post('aproval/izin/{id}/approve', [AprovalizinController::class,'approve'])->name('admin.izin.approve');
     //   Route::post('aproval/izin/{id}/reject', [AprovalizinController::class,'reject'])->name('admin.reject.approve');

     Route::get('admin/aprovaizin', [AprovalizinController::class, 'index'])->name('admin.aprovalizin');
   // Route::post('admin/aprovaizin/{id}/{status}', [AprovalizinController::class, 'updateStatus'])->name('admin.aprovalizin.update');
   Route::patch('/admin/aprovalizin/update/{id}/{status}', [AprovalizinController::class, 'updateStatus'])->name('admin.aprovalizin.update');

    Route::get('/admin/gaji', [GajiController::class, 'index'])->name('admin.gaji');
   // Route::get('/admin/gaji', [LaporanController::class, 'laporanGaji'])->name('admin.gaji');
     
    Route::post('/admin/gaji', [GajiController::class, 'store'])->name('admin.gaji.store');


     Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
       Route::get('/admin/laporan', [LaporanController::class, 'laporanKehadiran'])->name('admin.laporan');
    
    // DATA KARYAWAN
    Route::get('/admin/dataKaryawan/index', [AdminDataKaryawanController::class, 'index'])->name('admin.dataKaryawan.index');
Route::get('/admin/dataKaryawan/create', [AdminDataKaryawanController::class, 'create'])->name('admin.dataKaryawan.create');
Route::post('/admin/dataKaryawan', [AdminDataKaryawanController::class, 'store'])->name('admin.dataKaryawan.store');
     
});







Route::middleware(['auth', 'karyawan'])->group(function () {
  //  Route::get('/karyawan/dashboard', [KaryawanController::class, 'index']);
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');

    // route karyawan lainnya
       Route::get('/karyawan/absensi', [AbsensiController::class, 'index'])->name('karyawan.absensi');
       //  Route::post('/absensi', [AbsensiController::class, 'store'])->name('karyawan.absensi'); 
         Route::post('/karyawan/absensi', [AbsensiController::class, 'store'])->name('karyawan.absensi.store'); 

       //  Route::get('/riwayat',[RiwayatController::class,'index'])->name('karyawan.riwayat');  
        Route::get('/karyawan/riwayat',[AbsensiController::class,'riwayat'])->name('karyawan.riwayat'); 
        // Route::get('/riwayat',[RiwayatController::class,'index'])->name('karyawan.riwayat'); 

         Route::get('/karyawan/izin',[IzinController::class,'index'])->name('karyawan.izin'); 
         Route::post('/karyawan/izin',[IzinController::class,'store'])->name('karyawan.izin'); 
         
});

require __DIR__ . '/auth.php';
