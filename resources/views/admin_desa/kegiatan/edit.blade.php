@extends('admin_desa.layout')

@section('title', 'Edit Kegiatan | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Edit Kegiatan')
@section('container')

    <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header" style="background-color:#50A3B9">
                <h3 class="card-title">Edit Kegiatan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ url('kegiatan', $kegiatan->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Nama Kegiatan</label>
                        {{-- nama Nama Kegiatan --}}
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Isi Nama Kegiatan" value="{{ old('name', $kegiatan->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Edit</button>
                    <a href="/kegiatan" class="btn btn-outline-primary">
                        <span>Batalkan</span>
                    </a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
