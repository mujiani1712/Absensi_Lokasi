@extends('layouts.template')

@section('content')

<h1>Gaji Karyawan</h1>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Perhitungan Gaji</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
    <tr>
        <th>Nama Karyawan</th>
        <th>Hadir</th>
        <th>Alpha</th>
        <th>Hari Kerja</th>
        <th>Gaji Harian</th>
        <th>Gaji Pokok</th>
        <th>Potongan</th>
        <th>Gaji Bersih</th>
    </tr>
</thead>
<tbody>
    @foreach($gajiData as $data)
    <tr>
        <td>{{ $data['nama'] }}</td>
        <td>{{ $data['hadir'] }}</td>
        <td>{{ $data['alpha'] }}</td>
        <td>{{ $data['hari_kerja'] }}</td>
        <td>Rp {{ number_format($data['gaji_harian']) }}</td>
        <td>Rp {{ number_format($data['gaji_pokok']) }}</td>
        <td>Rp {{ number_format($data['potongan']) }}</td>
        <td><strong>Rp {{ number_format($data['gaji_bersih']) }}</strong></td>
    </tr>
    @endforeach
</tbody>

            </tbody>
        </table>
    </div>
</div>

@endsection
