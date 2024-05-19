@extends('admin_desa.layout')

@section('title', 'Edit RW | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Edit RW')
@section('container')

<div class="col-md-4">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit RW</h3>
      </div>
      <form action="{{ url('rw', $rw->id) }}" method="POST">
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
                <label for="exampleFormControlSelect1">Nama RW</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Isi Nama RW" value="{{ old('name', $rw->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                   @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Dusun</label>
                <select class="form-control" id="dusun_id" name="dusun_id">
                    <option value="0" {{ (!$rw->dusun_id) ? 'selected' : '' }}>Pilih Dusun</option>
                    @foreach ($dusun as $index)
                        <option value="{{ $index->id }}" {{ $index->id == $rw->dusun_id ? 'selected' : '' }}>
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
          <a href="/rw" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

