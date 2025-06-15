@extends('layouts.template')

@section('content')

<h1>Gaji Karyawan</h1>

    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Perhitungan Gaji</h3>
    </div>
    <div class="card-body">
     <table class="table table-bordered">
        <thead class="thead-dark text-center">
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Nama Karyawan</th>
                <th class="border px-4 py-2">Hadir</th>
                <th class="border px-4 py-2">Alpha</th>
                <th class="border px-4 py-2">Gaji Pokok</th>
                <th class="border px-4 py-2">Potongan</th>
                <th class="border px-4 py-2">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataGaji as $gaji)
                <tr>
                    <td style="text-align: center">{{ $gaji['nama'] }}</td>
                    <td style="text-align: center">{{ $gaji['hadir'] }}</td>
                    <td style="text-align: center">{{ $gaji['alpha'] }}</td>
                    <td style="text-align: center">Rp {{ number_format($gaji['gaji_pokok']) }}</td>
                    <td style="text-align: center">Rp {{ number_format($gaji['potongan']) }}</td>
                    <td style="text-align: center"><strong>Rp {{ number_format($gaji['gaji_bersih']) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>




@endsection

    