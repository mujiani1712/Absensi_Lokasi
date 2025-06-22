@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">Tambah Data Karyawan</div>

    <div class="card-body">
        <form action="{{ route('admin.dataKaryawan') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon:</label>
                <input type="text" name="no_telp" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat:</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Masuk Kerja:</label>
                <input type="date" name="tanggal_masuk" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

{{-- Tabel Daftar Karyawan --}}
<div class="card mt-4">
    <div class="card-header">Daftar Karyawan</div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $karyawan)
                    <tr>
                        <td>{{ $karyawan->name }}</td>
                        <td>{{ $karyawan->user->email ?? '-' }}</td>
                        <td>{{ $karyawan->user->no_telp ?? '-' }}</td>
                        <td>{{ $karyawan->user->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $karyawan->user->tanggal_lahir ?? '-' }}</td>
                        <td>{{ $karyawan->user->alamat ?? '-' }}</td>
                        <td>{{ $karyawan->tanggal_masuk }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
