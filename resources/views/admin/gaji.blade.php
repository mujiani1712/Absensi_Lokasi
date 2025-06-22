@extends('layouts.template')

@section('content')

<h1>Gaji Karyawan</h1>

    {{--}}
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Gaji Karyawan</h3>
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
    --}}



<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekap Gaji Bulan {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h3>
    </div>

    <div class="card-body">
       
        <form method="POST" action="{{ route('admin.gaji.store') }}">
            @csrf
            <button class="btn btn-success mb-3" onclick="return confirm('Hitung ulang gaji bulan ini?')">
                Hitung Gaji Bulan Ini
            </button>
        </form>

       
        <table class="table table-bordered table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No</th>
                    <th>periode,</th>
                    <th>Nama Karyawan</th>
                    <th>Hadir</th>
                    <th>Alpha</th>
                    <th>Sakit</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan</th>
                    <th>Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                         <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td> 
                        <td>{{ $item->karyawan->name ?? '-' }}</td>
                       
                        <td class="text-center">{{ $item->hadir }}</td>
                        <td class="text-center">{{ $item->alpha }}</td>
                        <td class="text-center">{{ $item->sakit }}</td>
                        <td class="text-right">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="text-right text-danger">-Rp {{ number_format($item->potongan, 0, ',', '.') }}</td>
                        <td class="text-right text-success">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data gaji bulan ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>






@endsection

    