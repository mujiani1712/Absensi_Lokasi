@extends('layouts.template')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Daftar Karyawan</h2>

    {{-- Tombol Tampilkan Form --}}
    <button onclick="toggleForm()" class="mb-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        + Tambah Karyawan Baru
    </button>

    {{-- Form Tambah Karyawan --}}
    {{-- <div id="form-karyawan" class="hidden mb-6 bg-white border border-gray-300 p-4 rounded shadow"> --}}
        <div id="form-karyawan" style="display: none;" class="mb-6 ...">

        <h3 class="text-lg font-semibold mb-4">Form Tambah Karyawan</h3>
        <form action="{{ route('admin.dataKaryawan.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label>Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" value="{{ now()->toDateString() }}" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label>Tanggal Mulai Kerja</label>
                    <input type="date" name="tanggal_mulai" class="w-full border p-2 rounded" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Karyawan --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border text-sm">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Jenis Kelamin</th>
                <th class="px-4 py-2 border">Alamat</th>
                <th class="px-4 py-2 border">Tanggal Daftar</th>
                <th class="px-4 py-2 border">Tanggal Mulai</th>
            </tr>
        </thead>
        <tbody>
          @forelse($karyawans as $karyawan) 
         
                <tr>
                    
                    <td class="border px-4 py-2">{{ $karyawan->name   }}</td>
                    <td class="border px-4 py-2">{{ $karyawan->email  }}</td>
                   
                       {{--
                     <td class="border px-4 py-2">{{ $karyawan->user->name  ?? '-'  }}</td>
                    <td class="border px-4 py-2">{{ $karyawan->user->email  ?? '-' }}</td>
                      --}}
                    <td class="border px-4 py-2">{{ $karyawan->jenis_kelamin }}</td>
                    <td class="border px-4 py-2">{{ $karyawan->alamat }}</td>
                    <td class="border px-4 py-2">{{ $karyawan->tanggal_daftar }}</td>
                    <td class="border px-4 py-2">{{ $karyawan->tanggal_mulai }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">Belum ada karyawan.</td>
                </tr>
           @endforelse 
         
        </tbody>
    </table>
</div>

{{-- Script Toggle --}}
<script>
   function toggleForm() {
    const form = document.getElementById('form-karyawan');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

</script>
@endsection
