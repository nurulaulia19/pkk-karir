@extends('admin_kab.layout')

@section('title', 'Edit Data Kategori Pemanfaatan Tanah Pekarangan | Super Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Kategori Pemanfaatan Tanah Pekarangan')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Edit Kategori Pemanfaatan Tanah Pekarangan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ url ('/data_kategori_pemanfaatan_lahan', $pemanfaatan->id) }}" method="POST">
      {{-- @dump($data_desa) --}}
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ $pemanfaatan->nama_kategori }}">
                @error('nama_kategori')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Edit</button>
          <a href="/data_kategori_pemanfaatan_lahan" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

