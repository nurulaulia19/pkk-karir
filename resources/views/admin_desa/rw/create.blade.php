@extends('admin_desa.layout')

@section('title', 'Tambah RW | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah RW')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah RW</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('rw.store') }}" method="POST">
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
                <label for="exampleFormControlSelect1">Nama RW</label>
                    {{-- nama Nama RW --}}
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama RW" value="{{ old('name') }}">
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
            <a href="/rw" class="btn btn-outline-primary">
                <span>Batalkan</span>
            </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

