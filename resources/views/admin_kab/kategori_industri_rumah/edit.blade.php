@extends('admin_kab.layout')

@section('title', 'Edit Data Kategori Industri Rumah Tangga | Super Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Kategori Industri Rumah Tangga')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Kategori Industri Rumah Tangga</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ url ('/data_kategori_industri', $industri->id) }}" method="POST">
      {{-- @dump($data_desa) --}}
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ $industri->nama_kategori }}">
                @error('nama_kategori')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
          <a href="/data_kategori_industri" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

