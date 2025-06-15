{{--}}
@extends('layouts.templatekaryawan')
@section('content')
<h1 class="mb-4 text-center">Dashboard Karyawan</h1>

<div class="d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="max-width: 1000px; width: 100%;">
        <img src="{{ asset('imgFoto/tokoDila.jpeg') }}" 
             class="img-fluid rounded-top" 
             alt="Foto Toko" 
             style="width: 100%; height: auto; border-bottom: 1px solid #ddd;">
        <div class="card-body">
            <h5 class="card-title">Toko Dila Travel</h5>
            <p class="card-text">
                Selamat datang di dashboard karyawan Toko Dila. Berikut adalah tampilan toko kami secara langsung.
                Gunakan menu di sebelah kiri untuk mengakses fitur absensi, pengajuan izin, dan lainnya.
            </p>
            <p class="card-text">
                <small class="text-muted">Terakhir diperbarui: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</small>
            </p>
        </div>
    </div>
</div>
@endsection

{{
@extends('layouts.templatekaryawan')
@section('content')
<h1 class="mb-4">Dashboard Karyawan</h1>

<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="max-width: 800px; width: 100%;">
        <img src="{{ asset('imgFoto/tokoDila.jpeg') }}" class="card-img-top img-fluid rounded-top" alt="Foto Toko" style="max-height: 400px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">Toko Dila Travel</h5>
            <p class="card-text">Selamat datang di dashboard karyawan Toko Dila. Berikut adalah tampilan toko fisik kami. Silakan gunakan menu di sebelah kiri untuk mengakses fitur-fitur lainnya.</p>
            <p class="card-text"><small class="text-muted">Terakhir diperbarui: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</small></p>
        </div>
    </div>
</div>
@endsection

--}}

@extends('layouts.templatekaryawan')
@section('content')
<h1 class="mb-4">Dashboard Karyawan</h1>

<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="max-width: 800px; width: 100%;">
        {{-- Gambar Toko --}}
        <img src="{{ asset('imgFoto/tokoDila.jpeg') }}" class="card-img-top img-fluid rounded-top" alt="Foto Toko" style="max-height: 400px; object-fit: cover;">

        <div class="card-body">
            {{-- Judul dan Deskripsi --}}
            <h5 class="card-title">Toko Dila Travel</h5>
            <p class="card-text">Selamat datang di dashboard karyawan Toko Dila. Berikut adalah tampilan toko fisik kami. Silakan gunakan menu di sebelah kiri untuk mengakses fitur-fitur lainnya.</p>

            {{-- Tanggal update --}}
            <p class="card-text"><small class="text-muted">Terakhir diperbarui: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</small></p>

            {{-- Google Maps Embed --}}
            <div class="mt-4">
    <h6>Lokasi Toko:</h6>
    <div class="ratio ratio-16x9">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127492.51097309648!2d128.2880136!3d-3.6090083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6c93b483adc283%3A0x94cce109a2904713!2sDilla%20Travel!5e0!3m2!1sid!2sid!4v1717518909245!5m2!1sid!2sid"
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

        </div>
    </div>
</div>
@endsection
