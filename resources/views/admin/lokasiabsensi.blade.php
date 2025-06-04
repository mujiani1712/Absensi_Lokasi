@extends('layouts.template')


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lokasi</h3>
    </div>
    <div class="card-body">
        


    <div class="container" >
        <h2 >Lokasi Absensi</h2>
     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
       {{--  <form action="{{ route('admin.lokasiabsensi.update') }}" method="POST"> --}}
        <form action="{{ route('admin.lokasiabsensi') }}" method="post">
            

            @csrf
            <div class="form-group">
                <label>Nama Toko</label>
                <input type="text" name="nama_toko" value="{{ $lokasi->nama_toko ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" value="{{ $lokasi->latitude ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" value="{{ $lokasi->longitude ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Radius (Meter)</label>
                <input type="text" name="radius" value="{{ $lokasi->radius ?? '' }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Lokasi</button>
        </form>
    </div> <br>

    @if($lokasi)  
    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Nama Toko</th>
            <th scope="col">Latitude</th>
            <th scope="col">Longitude</th>
            <th scope="col">Radius</th>
           
        
            
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{$lokasi->nama_toko}}</th>
               <td>{{$lokasi->latitude }}</td>
                 <td>{{ $lokasi->longitude }}</td>
              {{--}}  <td>{{ (float) $lokasi->latitude }}</td>
                <td>{{ (float) $lokasi->longitude }}</td>  --}}

                <td>{{ $lokasi->radius }}</td>
               
              
            </tr>
          
          
        
            
        </tbody>
        </table>

        
        @else  <!--br-->
            <p class="text-muted">Belum ada data lokasi absensi.</p>
        @endif 



   </div>
</div>
@endsection