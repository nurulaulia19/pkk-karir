@extends('admin_kab.layout')

@section('title', 'Tambah Data Berita PKK | Admin PKK Kab. Indramayu')

@section('bread', 'Tambah Data Berita PKK')
@section('container')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Data Berita PKK</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('beritaKab.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{  ($error)  }}</li>

                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="form-group">
            <label>Nama Berita</label>
            <input type="text" class="form-control @error('nama_berita') is-invalid @enderror" name="nama_berita" id="nama_berita" placeholder="Masukkan Nama Berita" required value="{{old('nama_berita')}}">
            @error('nama_berita')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label>Tanggal Publish Berita</label>
            <input type="date" class="form-control @error('tgl_publish') is-invalid @enderror" name="tgl_publish" id="tgl_publish" placeholder="Masukkan Tanggal Berita" required value="{{old('tgl_publish')}}">
            @error('tgl_publish')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Penulis Berita</label>
            <input type="text" class="form-control @error('penulis') is-invalid @enderror" name="penulis" id="penulis" placeholder="Masukkan Penulis Berita" required value="{{old('penulis')}}">
            @error('penulis')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Gambar Berita</label> <br>
            <input name="gambar" type="file" class="form-control-file @error('gambar') is-invalid @enderror" id="gambar" accept=".img, .jpg, .jpeg, .png" required>
            @error('gambar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{-- <img src="{{asset('gambar/'. $c->logo)}}" class="img-thumbnail" width="100px"> --}}
            {{-- <input name="logo" type="hidden" name="hidden_image" value="{{asset('gambar/'. $c->logo)}}" class="form-control-file" id="hidden_image"> --}}
          </div>
          <div class="form-group">
            <label>Deskripsi Berita</label>
            <textarea type="text" class="form-control @error('desk') is-invalid @enderror" name="desk" id="desk" rows="5" placeholder="Masukkan Deskripsi Berita" required>{{old('desk')}}</textarea>
            @error('desk')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/beritaKab" class="btn btn-outline-danger">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

@push('script-addon')

<script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // CKEDITOR.replace('desk');
    CKEDITOR.replace('desk', {
            on: {
                instanceReady: function(evt) {
                    this.on('notificationShow', function(event) {
                        if (event.data.message.indexOf('not secure') !== -1) {
                            event.cancel(); // Cancel the notification
                        }
                    });
                }
            }
        });
</script>
@endpush
