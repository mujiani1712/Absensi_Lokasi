<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
class RekapanController extends Controller
{
    //

    /*
      public function index(){
        return view('admin.rekapan');

    }

     public function rekapan(Request $request){
       
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');

       $absensi_terakhir = Karyawan::whereHas('absensi', function ($query) use ($tanggal) {
    $query->whereDate('created_at', $tanggal);
    })
    ->with(['absensi' => function ($query) use ($tanggal) {
    $query->whereDate('created_at', $tanggal);
    }])->get();



       // dd($rekap);
       return view('admin.rekapan',compact('absensi_terakhir','tanggal'));
    }

    */
       public function index(Request $request){
       // return view('admin.rekapan');
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');

       $absensi_terakhir = Karyawan::whereHas('absensi', function ($query) use ($tanggal) {
        $query->whereDate('created_at', $tanggal);
        })
        ->with(['absensi' => function ($query) use ($tanggal) {
        $query->whereDate('created_at', $tanggal);
        }])->get();

          return view('admin.rekapan',compact('absensi_terakhir','tanggal'));


    }
}

