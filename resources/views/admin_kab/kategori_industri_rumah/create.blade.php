@extends('admin_kab.layout')

@section('title', 'Kategori Industri Rumah Tangga | Admin PKK Kab. Indramayu')

@section('bread', 'Kategori Industri Rumah Tangga')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Kategori Industri Rumah Tangga</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_kategori_industri.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori Industri</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori" id="nama_kategori" placeholder="Masukkan Nama Kategori Industri" value="{{ old('nama_kategori') }}" required>
                @error('nama_kategori')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <a href="/data_industri_rumah" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

