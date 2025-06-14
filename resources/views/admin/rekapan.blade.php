@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekapan Absensi</h3>
    </div>
    <div class="card-body">
        Rekapan Karyawan
        
        <form method="GET" action="{{ route('admin.rekapan') }}" class="mb-3">
           {{--}} <input type="date" name="tanggal" value="{{ $tanggal }}" required> --}}
           <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" >

            
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <table class="table table-bordered">
            <thead class="thead-dark text-center">
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Foto Masuk</th>
                    <th scope="col">Jam Masuk</th>
                    <th scope="col">Foto Pulang</th>
                    <th scope="col">Jam Pulang</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $item)
                <tr>

                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>
                        @if($item['foto_masuk'])
                          <img src="{{ asset( $item['foto_masuk']) }}" width="100"> 
                           
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item['jam_masuk'] }}</td>
                    <td>
                        @if($item['foto_pulang'])
                          <img src="{{ asset( $item['foto_pulang']) }}" width="100"> 
                           
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item['jam_pulang'] }}</td>
                    <td>{{ $item['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
