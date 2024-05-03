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
                    <div class="form-group @error('warga_id') is-invalid @enderror">
                        <label for="exampleFormControlSelect1">Nama Keluarga</label>
                        <select class="form-control" id="warga_id" name="warga_id">
                          {{-- nama warga --}}
                          <option hidden> Pilih Kepala Keluarga</option>
                            @foreach ($warga as $warga)
                                <option value="{{ $warga->id }}">{{ $warga->nama_kepala_keluarga }} - {{$warga->no_ktp}}</option>
                            @endforeach
                          </select>
                      </div>
                      @error('warga_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group @error('nama_kategori') is-invalid @enderror">
                        <label>Kategori</label>
                        <select class="form-control" id="nama_kategori" name="nama_kategori">
                            <option hidden> Pilih Kategori</option>
                            @foreach ($kateagoriIndustri as $item)
                                    <option value="{{ $item->id }}" value="Konveksi">{{ $item->nama_kategori }}</option>

                            @endforeach
                            {{-- <option value="Pangan">Pangan</option>
                            <option value="Konveksi">Konveksi</option>
                            <option value="Sandang">Sandang</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lain-lain">Lain-lain</option> --}}
                        </select>
                      </div>
                      @error('nama_kategori')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                      @enderror
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

