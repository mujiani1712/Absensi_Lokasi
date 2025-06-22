
@extends('layouts.template')
@section('content')

<div class="max-w-2xl mx-auto p-4 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Tambah Karyawan Baru</h2>

    <form action="{{ route('admin.dataKaryawan.store') }}" method="POST"> 
        <form action="#" method="#">
        @csrf

        <!-- Nama -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Nama</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium">Alamat</label>
            <textarea name="alamat" class="w-full border p-2 rounded" rows="3" required></textarea>
        </div>

        <!-- Tanggal Daftar -->
        <div class="mb-4">
            <label for="tanggal_daftar" class="block text-sm font-medium">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="w-full border p-2 rounded" value="{{ now()->toDateString() }}" required>
        </div>

        <!-- Tanggal Mulai Kerja -->
        <div class="mb-4">
            <label for="tanggal_mulai" class="block text-sm font-medium">Tanggal Mulai Kerja</label>
            <input type="date" name="tanggal_mulai" class="w-full border p-2 rounded" required>
        </div>

        <!-- Tombol Submit -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Karyawan
            </button>
        </div>
    </form>
</div>

@endsection
