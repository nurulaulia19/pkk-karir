@extends('admin_kab.layout')

@section('title', 'Tambah Data Kabupaten | Super Admin PKK Kab. Indramayu')

@section('bread', 'Tambah Data Kabupaten')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Kabupaten</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_kabupaten.store') }}" method="POST">
        @csrf
        <div class="card-body">
             <div class="form-group">
                <label for="exampleFormControlSelect1">Provinsi</label>
                <select class="form-control" id="provinsi_id" name="provinsi_id">
                      @foreach ($provinsi as $c)
                          <option value="{{$c->id }}">  {{$c->kode_provinsi }}-{{ $c->name }}</option>
                      @endforeach
                </select>
              </div>
            <div class="form-group">
                <label>Kode Kabupaten</label>
                <input type="text" class="form-control" name="kode_kabupaten" id="kode_kabupaten" placeholder="Masukkan Kode Kabupaten" required>
            </div>
            <div class="form-group">
                <label>Nama Kabupaten</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Kabupaten" required>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <a href="/data_kabupaten" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

