@extends('admin_kab.layout')

@section('title', 'Edit Data Kabupaten | Super Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Kabupaten')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Edit Data Kabupaten</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ url ('/data_kabupaten', $kabupaten->id) }}" method="POST">
      {{-- @dump($kabupaten) --}}
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Provinsi</label>
                <select class="form-control" id="provinsi_id" name="provinsi_id">
                    @foreach ($provinsi as $index)
                        <option value="{{ $index->id }}" {{ $index->id === $kabupaten->provinsi_id ? 'selected' : '' }}>
                            {{ $index->kode_provinsi }}-{{ $index->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kode Kabupaten</label>
                <input type="text" class="form-control" name="kode_kabupaten" id="kode_kabupaten" placeholder="Masukkan Kode Kabupaten" required value="{{ucfirst(old('kode_kabupaten', $kabupaten->kode_kabupaten))}}" >
            </div>
            <div class="form-group">
                <label>Nama Kabupaten</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Kabupaten" required value="{{ucfirst(old('name', $kabupaten->name))}}">
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Edit</button>
          <a href="/data_kabupaten" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

