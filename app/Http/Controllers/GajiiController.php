<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;

class GajiiController extends Controller
{
 public function index()
    {

        $dataGaji = Gaji::all(); // ambil dari database
    return view('admin.gaji', compact('dataGaji'));
   
    }
}
