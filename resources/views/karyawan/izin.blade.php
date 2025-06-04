@extends('layouts.templatekaryawan')


@section('content')






  <div class="card">
    <div class="card-header">
      Form Pengajuan Izin
    </div>
    <div class="card-body">
      
          
          <button class="btn  btn-sm btn-primary" onclick="formDataIzin()">Tambah Data</button>
    </div> 
      <div class="card-body"> 
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


         <div id="formIzin" style="display: none;">
          <form  method="post" action="{{ route('karyawan.izin')}}">
            @csrf

            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Tanggal Pengajuan</label>
                <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan" value="{{ old('tanggal_pengajuan')}}" required>
              
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationTooltip02">Tanggal Izin</label>
                <input type="date" class="form-control" name="tanggal_izin" id="tanggal_izin" value="{{ old('tanggal_izin')}}" required>
               
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationTooltip03">Tanggal Berakhir Izin</label>
                <input type="date" class="form-control" name="tanggal_berakhir_izin" id="tanggal_berakhir_izin" value="{{ old('tanggal_berakhir_izin')}}" required>
               
              </div>
              
              
              <div class="col-md-6 mb-3">
                <label for="validationTooltip03">Keterangan</label>
                <input type="text" class="form-control"  name="keterangan" id="keterangan" value="{{ old('keterangan')}}" required>
               
              </div> <br>
            
            <button class="btn btn-primary" type="submit">Submit </button>
          </form>
         </div>
      </div>
  </div>



  

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Pengajuan</th>
            <th>Tanggal Izin</th>
            <th>Tanggal Berakhir Izin</th>
            <th>Keterangan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($izin as $key => $data )
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$data ->tanggal_pengajuan}}</td>
                <td>{{$data ->tanggal_izin}}</td>
                <td>{{$data ->tanggal_berakhir_izin}}</td>
                <td>{{$data ->keterangan}}</td>
                <td>{{ ucfirst($data->status) }}</td>

              </tr>
            
            @endforeach
        </tbody>
     

  




  <script>
    function formDataIzin() {
      const form = document.getElementById('formIzin');
      form.style.display = form.style.display === 'none'? 'block' : 'none';
    }
  </script>
@endsection