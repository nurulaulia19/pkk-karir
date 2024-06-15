@extends('admin_kab.layout')

@section('title', 'Edit Data Berita PKK | Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Berita PKK')
@section('container')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Edit Data Berita PKK</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ url ('/beritaKab', $beritaKab->id) }}" method="POST" enctype="multipart/form-data">
      {{-- @dump($berita) --}}
        @method('PUT')
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
                <label>Nama Berita</label>
                <input type="text" class="form-control @error('nama_berita') is-invalid @enderror" name="nama_berita" id="nama_berita" placeholder="Masukkan Nama Berita" value="{{$beritaKab->nama_berita}}">
                @error('nama_berita')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Publish Berita</label>
                <input type="date" class="form-control @error('tgl_publish') is-invalid @enderror" name="tgl_publish" id="tgl_publish" placeholder="Masukkan Tanggal Publsih Berita" value="{{$beritaKab->tgl_publish}}">
                @error('tgl_publish')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Penulis Berita</label>
                <input type="text" class="form-control @error('penulis') is-invalid @enderror" name="penulis" id="penulis" placeholder="Masukkan Penulis Berita" value="{{$beritaKab->penulis}}">
                @error('penulis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Gambar Berita</label> <br>
                <input name="gambar" type="file" class="form-control-file @error('gambar') is-invalid @enderror" id="gambar" accept=".img, .jpg, .jpeg, .png">
                <img src="/gambar/{{($beritaKab->gambar)}}" class="img-thumbnail" width="100px">
                <input name="gambar" type="hidden" name="hidden_image" value="{{asset('gambar/'. $beritaKab->gambar)}}" class="form-control-file" id="hidden_image">
                @error('gambar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Deskripsi Berita</label>
                <textarea type="text" class="form-control @error('desk') is-invalid @enderror" name="desk" id="desk" rows="5" placeholder="Masukkan Deskripsi Berita">{{ $beritaKab->desk }}</textarea>
                @error('desk')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Edit</button>
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

<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('desk');
</script>
@endpush

