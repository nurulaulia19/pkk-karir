@extends('admin_desa.layout')

@section('title', 'Tambah RT | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah RT')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah RT</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('rt.store', ['rw' => $rw ]) }}" method="POST">


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
                        <label for="exampleFormControlSelect1">Nama RT</label>
                        {{-- nama Nama RT --}}
                        <input type="hidden" name="rw" value="{{ $rw }}">

                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama RT" value="{{ $nextId }}">
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
            <a href="{{ route('rw.show', ['id' => $rw]) }}" class="btn btn-outline-primary">
                <span>Batalkan</span>
            </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

