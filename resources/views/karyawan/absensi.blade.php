@extends('layouts.templatekaryawan')
@section('content')

<div class="card">
    <div class="todaypresences">
        <div class="row">
            <!--masuk-->
            <div class="col-6">
                <div class="card bg-green">
                    <div class="card-body">
                        <div class="presencecontebt">
                            <div class="iconpresence">
                                <ion-icon name="camera"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                <span id="jamMasuk">--:--</span>
                            </div>
                        </div>
                       {{--}} <button id="btnAbsenMasuk" onclick="capturePhoto()">Absen Masuk</button> --}}
                        <button id="btnAbsenMasuk" onclick="capturePhoto('masuk')">Absen Masuk</button>

                    </div>
                </div>
            </div>
            <!--pulang-->
            <div class="col-6">
                <div class="card bg-red ">
                    <div class="card-body">
                        <div class="presencecontebt">
                            <div class="iconpresence">
                                <ion-icon name="camera">
                                <i class="fas fa-camera"></i></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                <span id="jamPulang">--:--</span>
                            </div>
                        </div>
                      {{--}}  <button type="button" onclick="capturePhoto('pulang')">Absen Pulang </button> --}}
                         <button id="btnAbsenPulang" onclick="capturePhoto('pulang')">Absen Pulang</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
     <!-- video Kamera masuk-->
    <div class="mt-4 text center">
        <video id="video" width="320" height="240" autoplay></video>
        <canvas id="canvas" width="320" height="240" style="display: none"></canvas>
        <img id="previewFoto" src="" width="320" height="240" style="display: none; margin-top:10; border: 2px solid white;"/> <!--pengambil cekrek foto-->

        <button type="button" id="btnAmbilFoto" onclick="ambilFoto()" style="display: none;" class="btn-primary mt-2">
            Ambil Foto
        </button>
    </div>

    <!--form Presensi-->
   
     <form action="{{ route('karyawan.absensi.store') }}" method="post"> 
      
    @csrf
        <!--input tersembnyi untk di kirmkan ke serve -->
       {{--}} <input type="hidden" name="name" id="name"> --}}
     {{--}}  <input type="hidden" name="name" id="name" value="{{ Auth::user()->name }}">  pakai--}} 
       <input type="hidden" name="name" id="name" value=" {{ Auth::user()->karyawan->name ?? Auth::user()->name }}"> {{--baru--}}
        
        <input type="hidden" name="tipe" id="tipe">
        <input type="hidden" name="foto" id="foto">
        <input type="hidden" name="lokasi" id="lokasi">
        <input type="hidden" name="jam" id="jam">
       {{--}} <input type="hidden" name="status" id="status" value=""> --}}


        <button type="submit" id="btnSubmit" style="margin-top:10px;">Kirim Absen</button>
    </form>

{{--}}
@if(session('error'))
    <div class="d-flex justify-content-center">
        
        <div class="alert alert-danger alert-dismissible fade show shadow rounded-3 px-4 py-3 d-flex align-items-center gap-3"
            role="alert"
            style="max-width: 800px; border-left: 5px solid #dc3545;" 
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

{{--}}
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
                        @foreach ($absensi_terakhir as $absen)
                            <tr>
                                <td>{{ $absen->tipe }}</td>
                                <td>
                                    <img src="{{ asset($absen->foto) }}" width="100" onerror="this.style.border='3px solid red';">
                                </td>
                                <td>{{ $absen->lokasi }}</td>
                                <td>{{ $absen->jam }}</td>
                                <td>{{ $absen->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    @endif
    --}}
   


</div>


@endsection

@push('scripts')
    <script>
        let stream = null;
        let currentTipe ='';

        async function startCamera(){
            if (!stream){
                try{
                    stream = await navigator.mediaDevices.getUserMedia({video:true});
                        document.getElementById('video').srcObject = stream;
                } catch (err){
                    alert("Gagal Mengakses kamera : "+ err.message);
                }
            }
        }

        //Menangkap Tipe Absensi
        function capturePhoto(tipe){
            currentTipe = tipe;
            startCamera();
            document.getElementById('btnAmbilFoto').style.display ='inline-block';
             //document.getElementById('btnSubmit').style.display ='none';
             document.getElementById('btnSubmit').style.display = 'inline-block';

        }
        //Mengambil Foto
        function ambilFoto() {
        
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
           // const dataURL = canvas.toDataURl('image/png');
            //const dataURL = canvas.toDataURL('image/png');
            const dataURL = canvas.toDataURL('image/png');



            document.getElementById('foto').value = dataURL;
            document.getElementById('previewFoto').src =dataURL;
            document.getElementById('previewFoto').style.display = 'block';
             video.style.display = 'none';

             document.getElementById('tipe').value = currentTipe;

             //UTK LOKASI
        navigator.geolocation.getCurrentPosition(function (position) {
                const lokasi = position.coords.latitude + ',' + position.coords.longitude;
                const jam = new Date().toLocaleTimeString();

                document.getElementById('lokasi').value = lokasi;
                document.getElementById('jam').value = jam;

                // Tampilkan jam pada UI
                if (currentTipe === 'masuk') {
                    document.getElementById('jamMasuk').innerText = jam;
                } else {
                    document.getElementById('jamPulang').innerText = jam;
                }

                document.getElementById('btnSubmit').style.display = 'inline-block';
                }, function (error) {
                    alert("Gagal mendapatkan lokasi: " + error.message);
                });
        }
    </script>
@endpush

