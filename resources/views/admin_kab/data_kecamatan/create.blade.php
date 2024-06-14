@extends('admin_kab.layout')

@section('title', 'Tambah Data Kecamatan | Super Admin PKK Kab. Indramayu')

@section('bread', 'Tambah Data Kecamatan')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Data Kecamatan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_kecamatan.store') }}" method="POST">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Kabupaten</label>
                <select class="form-control" id="kabupaten_id" name="kabupaten_id">
                      @foreach ($kabupaten as $c)
                          <option value="{{$c->id }}">  {{$c->kode_kabupaten }}-{{ $c->name }}</option>
                      @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kode Kecamatan</label>
                <input type="text" class="form-control" name="kode_kecamatan" id="kode_kecamatan" placeholder="Masukkan Kode Kecamatan" required>
            </div>
            <div class="form-group">
                <label>Nama Kecamatan</label>
                <input type="text" class="form-control" name="nama_kecamatan" id="nama_kecamatan" placeholder="Masukkan Nama Kecamatan" required>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/data_desa" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

