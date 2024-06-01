@extends('admin_desa.layout')

@section('title', 'Tambah Dusun | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah Dusun')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Dusun</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_dusun.store') }}" method="POST">
        @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Nama Dusun</label>
                        {{-- nama Nama Dusun --}}
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama Dusun">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="/dusun" class="btn btn-outline-primary">
                <span>Batalkan</span>
            </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

