@extends('admin_kab.layout')

@section('title', 'Tambah Data Galeri Kegiatan | Admin PKK Kab. Indramayu')

@section('bread', 'Tambah Data Galeri Kegiatan')
@section('container')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Data Gambar Galeri Kegiatan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('galeriKeg.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{  ($error)  }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
          <div class="form-group">
            <label>Keterangan Gambar</label>
            <input type="text" class="form-control @error('nama_gambar') is-invalid @enderror" name="nama_gambar" id="nama_gambar" placeholder="Masukkan Keterangan Gambar" required value="{{old('nama_gambar')}}">
            @error('nama_gambar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Nama Kegiatan</label>
            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" name="nama_kegiatan" id="nama_kegiatan" placeholder="Masukkan Nama Kegiatan Gambar" required value="{{old('nama_kegiatan')}}">
            @error('nama_kegiatan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label>Tanggal Publish Gambar</label>
            <input type="date" class="form-control @error('tgl_publish') is-invalid @enderror" name="tgl_publish" id="tgl_publish" placeholder="Masukkan Tanggal Publish Gambar" required value="{{old('tgl_publish')}}">
            @error('tgl_publish')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Pengirim Gambar</label>
            <input type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim" id="pengirim" placeholder="Masukkan Pengirim Gambar" required value="{{old('pengirim')}}">
            @error('pengirim')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Gambar Berita</label>
            <input name="gambar" type="file" class="form-control-file @error('gambar') is-invalid @enderror" id="gambar" accept=".img, .jpg, .jpeg, .png" value="{{old('gambar')}}">
            @error('gambar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{-- <img src="{{asset('gambar/'. $c->logo)}}" class="img-thumbnail" width="100px"> --}}
            {{-- <input name="logo" type="hidden" name="hidden_image" value="{{asset('gambar/'. $c->logo)}}" class="form-control-file" id="hidden_image"> --}}
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/galeriKeg" class="btn btn-outline-danger">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

