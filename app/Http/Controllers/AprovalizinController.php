<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
class AprovalizinController extends Controller
{


    //
 public function index()
    {
        $izin = Izin::all();
        return view('admin.aprovalizin', compact('izin'));
    }
    /*
    public function updateStatus($id, $status)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = $status;
        $izin->save();

        return redirect()->back()->with('success', 'Status izin diperbarui.');
    } */

    public function updateStatus($id, $status)
{
    $izin = Izin::findOrFail($id);
    
    if (!in_array($status, ['disetujui', 'ditolak'])) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $izin->status = $status;
    $izin->save();

    return redirect()->back()->with('success', 'Status izin berhasil diperbarui.');
}

}

