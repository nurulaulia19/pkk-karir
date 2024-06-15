@extends('admin_desa.layout')

@section('title', 'Tambah RT | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah RT')
@section('container')

    <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header" style="background-color: #50A3B9; color:white">
                <h3 class="card-title">Tambah RT</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ route('rt.store', ['rw' => $rw]) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Nama RT</label>
                        <input type="hidden" name="rw" value="{{ $rw }}">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Isi Nama RT" value="{{ old('name', $nextRtNumber) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Dusun</label>
                        <select class="form-control" id="dusun_id" name="dusun_id">
                            {{-- <option value="0" selected readonly>Pilih Dusun</option> --}}
                            <option value="0" selected>Tidak Memiliki Dusun</option>
                            @foreach ($dusun as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn" style="background-color:#50A3B9; color:white">Tambah</button>
                    <a href="{{ route('rw.show', ['id' => $rw_id]) }}" class="btn btn-outline-danger">
                        <span>Batalkan</span>
                    </a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
