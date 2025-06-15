

@extends('layouts.templatekaryawan')



@section('content')
    <div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Absen</h5>
        </div>
        <div class="card-body">

           
         <script>
    window.onload = function () {
            @if(session('success'))
                Swal.fire('Berhasil', '{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                Swal.fire('Gagal', '{{ session('error') }}', 'error');
            @endif
        }
</script>

            @if (isset($absensi_terakhir) && count($absensi_terakhir) > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Tipe</th>
                                <th>Foto</th>
                                <th>Lokasi</th>
                                <th>Jam</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data dari session --}}
                            @if (session('absen'))
                                <tr class="text-center">
                                    <td><span class="badge bg-info text-dark text-capitalize">{{ session('absen')['tipe'] }}</span></td>
                                    <td><img src="{{ session('absen')['foto'] }}" width="90" class="rounded shadow-sm border"></td>
                                    <td>{{ session('absen')['lokasi'] }}</td>
                                    <td>{{ session('absen')['jam'] }}</td>
                                    <td>{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            @endif

                            {{-- Data dari database --}}
                            @foreach ($absensi_terakhir as $absen)
                                <tr class="text-center">
                                    <td><span class="badge {{ $absen->tipe == 'masuk' ? 'bg-success' : 'bg-danger' }} text-capitalize">{{ $absen->tipe }}</span></td>
                                    <td>
                                        <img src="{{ asset($absen->foto) }}" width="90" class="rounded shadow-sm border" onerror="this.style.border='2px solid red';">
                                    </td>
                                    <td>{{ $absen->lokasi }}</td>
                                    <td>{{ $absen->jam }}</td>
                                    <td>{{ $absen->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i> Belum ada data riwayat absen.
                </div>
            @endif

        </div>
    </div>
</div>





@endsection

