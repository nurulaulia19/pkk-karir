@extends('admin_kab.layout')

@section('title', 'Edit Data Provinsi | Super Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Provinsi')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Edit Data Provinsi</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ url ('/data_provinsi', $provinsi->id) }}" method="POST">
      {{-- @dump($data_desa) --}}
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <label>Kode Provinsi</label>
                    <input type="text" class="form-control" name="kode_provinsi" id="kode_provinsi" placeholder="Masukkan Kode Provinsi" required value="{{ucfirst(old('kode_provinsi', $provinsi->kode_provinsi))}}" >
                  </div>
                <label for="name">Nama Provinsi</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $provinsi->name }}">
            </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Edit</button>
          <a href="/data_provinsi" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

