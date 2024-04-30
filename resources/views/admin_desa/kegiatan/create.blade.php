@extends('admin_desa.layout')

@section('title', 'Tambah Kegiatan | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Tambah Kegiatan')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Kegiatan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('kegiatan.store') }}" method="POST">
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
            {{-- <div class="form-group ">
                <label>Nama Kegiatan</label>
                <select class="form-control" id="id_kegiatan" name="id_kegiatan">
                    <option hidden> Pilih Kegiatan</option>
                    @foreach ($kegiatan as $c)
                        <option value="{{$c->id}}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group">
                <label for="exampleFormControlSelect1">Nama Kegiatan</label>
                    {{-- nama Nama Kegiatan --}}
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama Kegiatan" value="{{ old('name') }}">
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
          <a href="/kegiatan" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

