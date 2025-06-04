@extends('layouts.template')


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekapan Absensi</h3>
    </div>
    <div class="card-body">
        Rekapan Karyawan

        <table class="table table-bordered">
        
        <thead class="thead-dark text-center">

            <form method="GET" action="{{ route('admin.rekapan') }}">
                <input type="date" name="tanggal" value="{{ $tanggal }}" required>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <tr>
                
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Karyawan</th>
                <th scope="col">Foto Masuk</th>
                <th scope="col">Jam Masuk</th>
                <th scope="col">Foto Pulang</th>
                 <th scope="col">Jam Pulang</th>

            </tr>
        </thead>
        <tbody>
             
            @foreach ($absensi_terakhir as $absen)
            @php
                    /*
                    $absenMasuk = $karyawan->absensi ? $karyawan->firstWhere('tipe', 'masuk');
                    $absenPulang = $karyawan->absensi ? $karyawan->firstWhere('tipe', 'pulang');
                    */
                     $absenMasuk = $absen->absensi ->firstWhere('tipe', 'masuk');
                    $absenPulang = $absen->absensi ->firstWhere('tipe', 'pulang');
                @endphp
                
            <tr>

               {{--}} <td>{{$absen->tanggal }}</td> --}}
                
                <td>{{\carbon\carbon::now()->format('d-m-Y ')}}</td>  
                <td>{{$absen->name }}</td>
                <td>
                    @if($absenMasuk)
                        <img src="{{ asset ($absenMasuk->foto)}}" width="100">
                    @endif
                </td>
                <td>{{$absenMasuk->jam ?? '-'}}</td>
                <td>
                    @if($absenPulang)
                        <img src="{{ asset ($absenPulang->foto)}}" width="100">
                    @endif
                </td>
                <td>{{ $absenPulang->jam ?? '-'}}</td>
            </tr>
            @endforeach
            
            </tbody>
        </table>

    </div>
    </div>
@endsection