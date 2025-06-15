@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">Rekap Pengajuan Izin</div>
    <div class="card-body">
            {{--}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Izin</th>
                    <th>Tanggal Berakhir</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($izin as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->tanggal_pengajuan }}</td>
                        <td>{{ $data->tanggal_izin }}</td>
                        <td>{{ $data->tanggal_berakhir_izin }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{ ucfirst($data->status) }}</td>
                        <td>
                            @if ($data->status == 'pending')
                                <form action="{{ route('admin.aprovalizin.update', ['id' => $data->id, 'status' => 'disetujui']) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Setujui izin ini?')">Setujui</button>
                                </form>
                                <form action="{{ route('admin.aprovalizin.update', ['id' => $data->id, 'status' => 'ditolak']) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak izin ini?')">Tolak</button>
                                </form>
                            @else
                                {{ ucfirst($data->status) }}
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
