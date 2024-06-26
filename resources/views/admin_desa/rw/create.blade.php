@extends('admin_desa.layout')

@section('title', 'Tambah RW | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah RW')
@section('container')

    <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header" style="background-color: #50A3B9">
                <h3 class="card-title">Tambah RW</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ route('rw.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Nama RW</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Isi Nama RW" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Dusun</label>
                        <select class="form-control @error('dusun_id') is-invalid @enderror" id="dusun_id" name="dusun_id">
                            <option value="0" selected hidden>Pilih Dusun</option>
                            <option value="0" {{ old('dusun_id') == '0' ? 'selected' : '' }}>Tidak Memiliki Dusun</option>
                            @foreach ($dusun as $c)
                                <option value="{{ $c->id }}" {{ old('dusun_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('dusun_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
                    <a href="/rw" class="btn btn-outline-danger">
                        <span>Batalkan</span>
                    </a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
