<?php

namespace App\Http\Controllers;
use App\Models\Jamkerja;
use Illuminate\Http\Request;

class JamKerjaController extends Controller
{
          public function index(){
        $jamkerja = Jamkerja::first();
        return view('admin.jamkerja',compact('jamkerja'));
    }

   public function store (Request $request){
   // Log::info('Data dikirim:', $request->all());
    $request->validate([
      'jam_masuk'=> 'required|date_format:H:i',
      'jam_pulang'=> 'required|date_format:H:i|after:jam_masuk',
      'batas_terlambat'=> 'required|date_format:H:i',
    ]);

    try{
      
        Jamkerja::updateOrCreate(
      //['id'=> 1],
      ['id'=> Jamkerja::first()->id ?? null],
 
      [
        'jam_masuk'=> $request->jam_masuk,
        'jam_pulang'=> $request->jam_pulang,
        'batas_terlambat' => $request->batas_terlambat,

      ]);
      return redirect()->route('admin.jamkerja')->with('success','jam berhasil di simpan');
    }
      catch (\Exception $e) {
      return redirect()->route('admin.jamkerja')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
  }

  public function destroy(){

    try{
      $jamkerja = Jamkerja::first();
      if ($jamkerja){
        $jamkerja->delete();
        return redirect()->route('admin.jamkerja')->with('success', 'jam kerja berhasil di hapus');
      } else{
         return redirect()->route('admin.jamkerja')->with('error', 'data jama tidak temukan');
      }

    }  catch (\Exception $e) {
      return redirect()->route('admin.jamkerja')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }

  }
}
