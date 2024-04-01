@extends('admin_kab.layout')

@section('title', 'Tambah Data Provinsi | Super Admin PKK Kab. Indramayu')

@section('bread', 'Tambah Data Provinsi')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Provinsi</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_provinsi.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Kode Provinsi</label>
                <input type="text" class="form-control" name="kode_provinsi" id="kode_provinsi" placeholder="Masukkan Kode Provinsi" required>
            </div>
            <div class="form-group">
                <label>Nama Provinsi</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Provinsi" required>
            </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <a href="/data_provinsi" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

