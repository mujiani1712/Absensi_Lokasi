@extends('layouts.template')

@section('content')


    <div class="card">
        <div class="card-header">Data Karyawan</div>

         <form action="{{ route('admin.dataKaryawan') }}" method="POST"> 
       
    @csrf

    <div>
        <label>Nama:</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>

    <div>
         <label>Password:</label>
        <input type="password" name="password" required>
    </div>


    <div>
        <label>Nomor Telepon:</label>
        <input type="text" name="no_telp" required>
    </div>

    <div>
        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>

    <div>
        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required>
    </div>

    <div>
        <label>Alamat:</label>
        <textarea name="alamat" required></textarea>
    </div>

    <div>
        <label>Tanggal Masuk Kerja:</label>
        <input type="date" name="tanggal_masuk" required>
    </div>

    <button type="submit">Simpan</button>
</form>



        <div class="mt-4">
    <h5>Daftar Karyawan</h5>
    <table class="table table-bordered">
        <thead>
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
                    <td>{{ $karyawan->email }}</td>
                    <td>{{ $karyawan->no_telp }}</td>
                    <td>{{ $karyawan->jenis_kelamin }}</td>
                    <td>{{ $karyawan->tanggal_lahir }}</td>
                    <td>{{ $karyawan->alamat }}</td>
                    <td>{{ $karyawan->tanggal_masuk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <div class="card-body">


@endsection