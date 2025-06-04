@extends('layouts.template')

@section('content')

<h1>laporan</h1>
    {{--}}
    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekapan Absensi</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
        
            <thead class="thead-dark text-center">
               
                <form method="GET" action="{{ route('admin.rekapan') }}">
                    <input type="date" name="tanggal" value="{{ $tanggal }}" required>
                    <button type="submit" class="btn btn-primary">Cari</button> 
                </form>
                <tr>
                      <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Keterangan </th>
                    
                    </tr>
                </thead>
            <tbody>
        </table>

    </div>
    </div>
     --}}

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekapan Absensi</h3>
    </div>
    <div class="card-body">
     <table class="table table-bordered">
        <thead class="thead-dark text-center">
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Nama Karyawan</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td style="text-align: center" class="border px-4 py-2">{{ $item['tanggal'] }}</td>
                    <td style="text-align: center" class="border px-4 py-2">{{ $item['nama'] }}</td>
                    <td style="text-align: center" class="border px-4 py-2">
                        @if($item['status'] === 'Hadir')
                            <span class="text-green-600 font-semibold">Hadir</span>
                        @else
                            <span class="text-red-600 font-semibold">Alpha</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection