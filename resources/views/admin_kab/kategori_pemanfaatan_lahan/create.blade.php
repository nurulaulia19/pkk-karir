@extends('admin_kab.layout')

@section('title', 'Kategori Pemanfaatan Tanah Pekarangan | Admin PKK Kab. Indramayu')

@section('bread', 'Kategori Pemanfaatan Tanah Pekarangan')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Kategori Pemanfaatan Tanah Pekarangan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_kategori_pemanfaatan_lahan.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori Pemanfaatan Tanah Pekarangan</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" id="nama_kategori" placeholder="Masukkan Nama Kategori Pemanfaatan Tanah Pekarangan" value="{{ old('nama_kategori') }}" required>
                @error('nama_kategori')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/data_kategori_pemanfaatan_lahan" class="btn btn-outline-danger">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

