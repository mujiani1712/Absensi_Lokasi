

@extends('layouts.templatekaryawan')



@section('content')

<div class="card">
  <div class="card-header">
    Riwayat
  </div>
  <div class="card-body">
    {{--}}
     @if(session('error'))
    <div class="d-flex justify-content-center">
        
        <div class="alert alert-danger alert-dismissible fade show shadow rounded-3 px-4 py-3 d-flex align-items-center gap-3"
            role="alert"
            style="max-width: 800px; border-left: 5px solid #dc3545:" 
            <i class="bi bi-x-circle-fill fs-4 text-danger"></i>
            <div>
                <strong class="d-block">Gagal!</strong>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
--}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif




@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<!-- Tampilkan riwayat absen dari database -->
        @if (isset($absensi_terakhir) && count($absensi_terakhir) > 0)
            <h4 class="mt-5">Riwayat Absen Terakhir</h4>
            
                <table class="table table-bordered md-3">
                    <thead class="thead-dark">
            
                        <tr>
                            <th>Tipe</th>
                            <th>Foto</th>
                            <th>Lokasi</th>
                            <th>Jam</th>
                            <th>Tanggal</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      
                        @if (session('absen'))
                            <tr>
                                <td>{{ session('absen')['tipe']}}</td>
                                <td><img src="{{ session('absen')['foto']}}" width="100"></td>
                                <td>{{ session('absen')['lokasi']}}</td>
                                 <td>{{ session('absen')['jam']}}</td>

                                 <td>{{\carbon\carbon::now()->format('d-m-Y H:i:s')}}</td>
                                  {{--}} <td>{{ session('absen')['status']}}</td> --}}
                            </tr>
                        
                        @endif

                        @foreach ($absensi_terakhir as $absen)
                            <tr>
                                <td>{{ $absen->tipe }}</td>
                                <td>
                                    <img src="{{ asset($absen->foto) }}" width="100" onerror="this.style.border='3px solid red';">
                                </td>
                                <td>{{ $absen->lokasi }}</td>
                                <td>{{ $absen->jam }}</td>
                                <td>{{ $absen->created_at->format('d-m-Y H:i:s') }}</td>
                                {{--}} <td>{{ $absen->status }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
           
       
    
    @endif
    
       
  </div>
</div>





@endsection

