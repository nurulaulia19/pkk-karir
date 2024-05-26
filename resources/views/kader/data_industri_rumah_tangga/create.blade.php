@extends('kader.layout')

@section('title', 'Tambah Data Industri Rumah Tangga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Industri Rumah Tangga')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data Industri Rumah Tangga</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_industri.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <h6 style="color: red">* Semua elemen atribut harus diisi</h6>

            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{  ($error)  }}</li>

                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('id_desa') is-invalid @enderror">
                        {{-- nama desa --}}
                        <label for="exampleFormControlSelect1">Desa</label>
                        @foreach ($desas as $c)
                        <input type="hidden" class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{$c->id}}">

                        <input type="text" disabled class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{ $c->nama_desa }}">

                        @endforeach
                    </div>
                    @error('id_desa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-group @error('id_kecamatan') is-invalid @enderror">
                        {{-- nama kecamatan --}}
                        <label for="exampleFormControlSelect1">Kecamatan</label>
                        @foreach ($kec as $c)
                            <input type="hidden" class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Desa" required value="{{$c->id}}">
                            <input type="text" disabled class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Desa" required value="{{ $c->nama_kecamatan }}">
                        @endforeach
                    </div>
                    @error('id_kecamatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('keluarga_id') is-invalid @enderror">
                        <label for="exampleFormControlSelect1">Nama Keluarga</label>
                        <select class="form-control" id="keluarga_id" name="keluarga_id">
                          {{-- nama warga --}}
                          <option hidden> Pilih Kepala Keluarga</option>
                            @foreach ($keluarga as $index)
                                <option value="{{ $index->id }}">{{ $index->nama_kepala_keluarga }} - {{$index->nik_kepala_keluarga}}</option>
                            @endforeach
                          </select>
                      </div>
                      @error('keluarga_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group @error('kategori_industri_rumah_id') is-invalid @enderror">
                        <label>Kategori</label>
                        <select class="form-control" id="kategori_industri_rumah_id" name="kategori_industri_rumah_id">
                            <option selected disabled value="0"> Pilih Kategori</option>
                            @foreach ($kategoriIndustri as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                      </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @error('periode') is-invalid @enderror">
                    <label>Periode</label>
                    <select class="form-control" id="periode" name="periode" readonly>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    </select>
                </div>
                  @error('periode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
            </div>
            {{-- <div class="col-md-2">
                <div class="form-group @error('id_user') is-invalid @enderror">
                    @foreach ($kad as $c)
                        <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{$c->id}}">

                    @endforeach
                </div>
                @error('id_user')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
        </div>

    </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <a href="/data_industri" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

