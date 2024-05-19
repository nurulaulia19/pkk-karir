@extends('admin_desa.layout')

@section('title', 'Edit RT | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Edit RT')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit RT</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ url('rt', $rt->id) }}" method="POST">
        @method('PUT')
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
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama Kegiatan" value="{{ old('name', $rt->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Dusun</label>
                <select class="form-control" id="dusun_id" name="dusun_id">
                    <option value="0" {{ (!$rt->dusun_id) ? 'selected' : '' }}>Pilih Dusun</option>
                    @foreach ($dusun as $index)
                        <option value="{{ $index->id }}" {{ $index->id == $rt->dusun_id ? 'selected' : '' }}>
                            {{ $index->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
          <a href="/rt" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

