@extends('kader.layout')

@section('title', 'Tambah Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Keluarga')
@section('container')
    <div class="container">
        <ul class="nav nav-tabs" id="dataRumahTanggaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dasawisma-tab" data-toggle="tab" href="#dasawisma" role="tab"
                    aria-controls="dasawisma" aria-selected="true">Data Dasa Wisma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab"
                    aria-controls="keluarga" aria-selected="false">Data Rumah Tangga</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="kondisi-keluarga-tab" data-toggle="tab" href="#kondisi-keluarga" role="tab" aria-controls="kondisi-keluarga" aria-selected="false">Kriteria Rumah</a>
            </li>
        </ul>
        <form action="{{ route('data_rumah_tangga.store') }}" method="POST">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dasawisma" role="tabpanel" aria-labelledby="dasawisma-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-end mb-4">
                                <div class="col-md-2 d-flex justify-content-end">
                                    <!-- Tombol yang memicu modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modalSaya">
                                        Klik Info
                                    </button>
                                </div>
                            </div>

                            <h6 style="color: red">* Semua elemen atribut harus diisi</h6>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Dasawisma</label>
                                                {{-- <input type="text" class="form-control @error('dasa_wisma') is-invalid @enderror" name="dasa_wisma" id="dasa_wisma" placeholder="Masukkan Nama Dasa Wisma" value="{{ old('dasa_wisma') }}"> --}}
                                                <select class="form-control" id="id_dasawisma" name="id_dasawisma">
                                                    {{-- <option value="" hidden> Pilih Dasa Wisma</option> --}}
                                                    @foreach ($dasawisma as $c)
                                                        @if ($kader->id_dasawisma == $c->id)
                                                            <option selected value="{{ $c->id }}">
                                                                {{ $c->nama_dasawisma }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('dasa_wisma')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>RW</label>
                                                <input type="hidden" disabled class="form-control" name="rw_id" id="rw_id"  value="{{ $kader->dasawisma->rw_id }}">
                                                <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rw->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>RT</label>
                                                <input type="hidden" disabled class="form-control" name="rt_id" id="rt_id"  value="{{ $kader->dasawisma->rt_id }}">
                                                <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rt->name }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group @error('rw') is-invalid @enderror">
                                                <label for="exampleFormControlSelect1">Dusun</label>
                                                <input type="text"
                                                    class="form-control @error('dusun') is-invalid @enderror" name="dusun"
                                                    id="dusun" placeholder="Masukkan Nama Dusun"
                                                    value="{{ old('dusun') }}">
                                            </div>
                                            @error('dusun')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group @error('id_desa') is-invalid @enderror">
                                                <label for="exampleFormControlSelect1">Desa</label>
                                                @foreach ($desas as $c)
                                                    <input type="hidden" class="form-control" name="id_desa"
                                                        id="id_desa" placeholder="Masukkan Nama Desa"
                                                        value="{{ $c->id }}">
                                                    <input type="text" disabled class="form-control" name="id_desa"
                                                        id="id_desa" placeholder="Masukkan Nama Desa"
                                                        value="{{ $c->nama_desa }}">
                                                @endforeach
                                            </div>
                                            @error('id_desa')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group @error('id_kecamatan') is-invalid @enderror">
                                                <label for="exampleFormControlSelect1">Kecamatan</label>
                                                {{-- nama kecamatan --}}
                                                @foreach ($kec as $c)
                                                    <input type="hidden" class="form-control" name="id_kecamatan"
                                                        id="id_kecamatan" placeholder="Masukkan Nama Desa"
                                                        value="{{ $c->id }}">
                                                    <input type="text" disabled class="form-control"
                                                        name="id_kecamatan" id="id_kecamatan"
                                                        placeholder="Masukkan Nama Desa"
                                                        value="{{ $c->nama_kecamatan }}">
                                                @endforeach
                                            </div>
                                            @error('id_kecamatan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Kabupaten</label>
                                                {{-- nama kabupaten --}}
                                                <input type="text" readonly class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten" placeholder="Masukkan Kabupaten" value="{{ $kabupaten->name }}">
                                                    @error('kabupaten')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Provinsi</label>
                                                {{-- nama provinsi --}}
                                                <input type="text" readonly class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" placeholder="Masukkan Provinsi" value="{{ $provinsi->name }}">
                                                @error('provinsi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{-- pilih periode --}}
                                                <label>Periode</label>
                                                <select class="form-control" id="periode" name="periode" readonly>
                                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Periode</label>
                                                <select class="form-control" id="periode" name="periode" readonly>
                                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-action="next">Next</button>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-end mb-4">
                                <div class="col-md-2 d-flex justify-content-end">
                                    <!-- Tombol yang memicu modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modalSaya">
                                        Klik Info
                                    </button>
                                </div>
                            </div>
                            <h6 style="color: red">* Semua elemen atribut harus diisi</h6>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row" id="containerz">
                                <div class="col-md-12">
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <select name="nama_kepala_rumah_tangga" id="js-example-basic-multiple"
                                                    class="form-control js-example-basic-single" >
                                                    <option selected disabled>Type to search</option>
                                                    @foreach ($kk as $kepala)
                                                        <option value="{{ $kepala->id }}">{{ $kepala->nama_kepala_keluarga }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama_kepala_rumah_tangga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group @error('keluarga') is-invalid @enderror">
                                                <label>Nama</label>
                                                <select name="keluarga[]" id="js-example-basic-multiple"
                                                    class="form-control js-example-basic-single select-state @error('keluarga') is-invalid @enderror" placeholder="Type to search.." required>
                                                    <option value="">Pilih Nama Kepala Rumah Tangga</option>
                                                    @foreach ($kk as $kepala)
                                                        <option value="{{ $kepala->id }}" {{ (collect(old('keluarga'))->contains($kepala->id)) ? 'selected' : '' }}>{{ $kepala->nama_kepala_keluarga }} - {{ $kepala->nik_kepala_keluarga }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama_kepala_rumah_tangga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Status</label>
                                                <select class="form-control" id="id_dasawisma" name="status[]">
                                                    {{-- <option selected> -- pili status --</option> --}}
                                                    <option selected value="kepala-rumah-tangga">Kepala Rumah Tangga</option>
                                                    {{-- <option value="ibu">Ibu</option>
                                                    <option value="anak">Anak</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="addRow" type="button" class="btn" style="background-color: #50A3B9; color:white"><i class="fas fa-plus"></i> </i>
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" data-action="next" class="btn btn-primary">Next</button>
                            {{-- <button type="submit" class="ml-2 btn btn-success">submit</button> --}}

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kondisi-keluarga" role="tabpanel" aria-labelledby="kondisi-keluarga-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-end mb-4">
                                <div class="col-md-2 d-flex justify-content-end">
                                    <!-- Tombol yang memicu modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSaya">
                                        Klik Info
                                    </button>
                                </div>
                            </div>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        {{-- <div class="col-md-4">
                                            <div class="form-group @error('kriteria_rumah_sehat') is-invalid @enderror">
                                                <label>Kriteria Rumah</label><br>
                                                <select class="form-control @error('kriteria_rumah_sehat') is-invalid @enderror" id="kriteria_rumah_sehat" name="kriteria_rumah_sehat">
                                                    <option value="" hidden>Pilih Kriteria Rumah</option>
                                                    <option value=1>Sehat</option>
                                                    <option value=0>Kurang Sehat</option>
                                                </select>
                                            </div>
                                            @error('kriteria_rumah_sehat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                        <div class="col-md-4">
                                            <div class="form-group @error('punya_tempat_sampah') is-invalid @enderror">
                                                {{-- pilih punya tempat pembuangan sampah --}}
                                                <label class="@error('punya_tempat_sampah') is-invalid @enderror">Memiliki Tempat Pembuangan Sampah</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="punya_tempat_sampah" value="1" class="form-check-input" {{ old('punya_tempat_sampah') == '1' ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="punya_tempat_sampah" value="0" class="form-check-input" {{ old('punya_tempat_sampah') == '0' ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                                @error('punya_tempat_sampah')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <div class="form-group @error('saluran_pembuangan_air_limbah') is-invalid @enderror">
                                                <label>Mempunyai Saluran Pembuangan Air Limbah</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="saluran_pembuangan_air_limbah" value=1 class="form-check-input">Ya
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="saluran_pembuangan_air_limbah" value=0 class="form-check-input">Tidak
                                                        </label>
                                                    </div>
                                            </div>
                                            @error('saluran_pembuangan_air_limbah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                            <div class="form-group @error('saluran_pembuangan_air_limbah') is-invalid @enderror">
                                                {{-- pilih punya saluran pembuangan air limbah --}}
                                                <label class="@error('saluran_pembuangan_air_limbah') is-invalid @enderror">Mempunyai Saluran Pembuangan Air Limbah</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="saluran_pembuangan_air_limbah" value="1" class="form-check-input" {{ old('saluran_pembuangan_air_limbah') == '1' ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="saluran_pembuangan_air_limbah" value="0" class="form-check-input" {{ old('saluran_pembuangan_air_limbah') == '0' ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                                @error('saluran_pembuangan_air_limbah')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            {{-- <div class="form-group @error('tempel_stiker') is-invalid @enderror">
                                                <label>Menempel Stiker P4K</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="tempel_stiker" value=1 class="form-check-input">Ya
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="tempel_stiker" value=0 class="form-check-input">Tidak
                                                        </label>
                                                    </div>
                                            </div>
                                            @error('tempel_stiker')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                            <div class="form-group @error('tempel_stiker') is-invalid @enderror">
                                                {{-- pilih stiker --}}
                                                <label class="@error('tempel_stiker') is-invalid @enderror">Menempel Stiker P4K</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="tempel_stiker" value="1" class="form-check-input" {{ old('tempel_stiker') == '1' ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="tempel_stiker" value="0" class="form-check-input" {{ old('tempel_stiker') == '0' ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                                @error('tempel_stiker')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group @error('punya_jamban') is-invalid @enderror">
                                                <label class="@error('punya_jamban') is-invalid @enderror">Punya Jamban?</label>
                                                {{-- <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_ya" value=1>
                                                            <label class="form-check-label" for="punya_jamban_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_tidak" value=0>
                                                            <label class="form-check-label" for="punya_jamban_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_ya" value="1" {{ old('punya_jamban') == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="punya_jamban_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_tidak" value="0" {{ old('punya_jamban') == '0' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="punya_jamban_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('punya_jamban')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <div class="form-group">
                                                <label>Sumber Air:</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_pdam" name="sumber_air_pdam" value=1>
                                                    <label class="form-check-label" for="sumber_air_pdam">PDAM</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_sumur" name="sumber_air_sumur" value=1>
                                                    <label class="form-check-label" for="sumber_air_sumur">Sumur</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_lainnya" name="sumber_air_lainnya" value=1>
                                                    <label class="form-check-label" for="sumber_air_lainnya">Lainnya</label>
                                                </div>
                                            </div> --}}
                                            <div class="form-group @error('sumber_air') is-invalid @enderror">
                                                <label class="@error('sumber_air') is-invalid @enderror">Sumber Air:</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_pdam" name="sumber_air[]" value="pdam" {{ in_array('pdam', old('sumber_air', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sumber_air_pdam">PDAM</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_sumur" name="sumber_air[]" value="sumur" {{ in_array('sumur', old('sumber_air', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sumber_air_sumur">Sumur</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_lainnya" name="sumber_air[]" value="lainnya" {{ in_array('lainnya', old('sumber_air', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sumber_air_lainnya">Lainnya</label>
                                                </div>
                                                @error('sumber_air')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{-- <button type="button" data-action="next" class="btn btn-primary">Next</button> --}}
                            <button type="submit" class="ml-2 btn" style="background-color: #50A3B9; color:white">Tambah</button>
                            <a href="/data_rumah_tangga" class="btn btn-outline-danger">
                                <span>Batalkan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- Contoh Modal -->
    <div class="modal fade" id="modalSaya" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSayaLabel">Info Keterangan Atribut </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <th colspan="1">Point/Isian</th>
                            <th>Penjelasan</th>
                        </tr>
                        <tr>
                            <td>Nama Kepala Rumah Tangga</td>
                            <td>Di isi dengan nama Kepala Rumah Tangga pada rumah yang didata.
                                Kepala Rumah Tangga adalah yang bertanggung jawab atas segala sesuatu yang terkait dengan
                                kegiatan di dalam rumah yang sedang didata.</td>
                        </tr>
                        <tr>
                            <td>Stiker P4K (Program Perencanaan Persalinan dan Pencegahan Komplikasi)</td>
                            <td>Stiker P4K berisi data tentang : nama ibu hamil, taksiran persalinan, penolong persalinan,
                                tempat persalinan, pendamping persalinan, transport yang digunakan dan calon donor darah.
                            </td>
                        </tr>
                        <tr>
                            <td>Jamban</td>
                            <td>Suatu bangunan yang dipergunakan untuk membuang tinja atau kotoran manusia atau najis bagi
                                suatu keluarga yang lazim disebut kakus atau WC.</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-addon')
    <script type="text/javascript">
        $(function() {

            $("#datepicker").datepicker({

                changeMonth: true,

                changeYear: true

            });

        });

        window.onload = function() {

            $('#tgl_lahir').on('change', function() {

                var dob = new Date(this.value);

                var today = new Date();

                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));

                $('#umur').val(age);

            });

        }
    </script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    <script>
        $(document).on('click', '[data-action="next"]', function (e) {
            var $active = $('#dataRumahTanggaTabs .nav-link.active');
            var hasError = false;

            $($active.attr('href')).find('input[required]').each(function () {
                // Periksa input yang tidak disabled atau readonly
                if (!$(this).prop('disabled') && !$(this).prop('readonly') && !$(this).val()) {
                    $(this).addClass('is-invalid');
                    hasError = true;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!hasError) {
                // Temukan tab berikutnya dan aktifkan
                var $nextTab = $active.parent().next().find('a');
                if ($nextTab.length > 0) {
                    $nextTab.tab('show');
                }
            }
        });
    </script>

    <script>
        let data; // Variabel untuk menyimpan data warga
        let warga = 1; // Variabel untuk menyimpan nomor select

        // Fungsi untuk melakukan permintaan API sekali saja di awal
        $(document).ready(function() {
            $.ajax({
                url: "/keluarga",
                type: "GET",
                success: function(response) {
                    console.log(response);
                    data = response.keluarga; // Simpan data warga dalam variabel
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

    // Fungsi untuk menambahkan row saat tombol diklik
    // document.getElementById('addRow').addEventListener('click', function() {
    //     var container = document.getElementById('containerz');
    //     var rownew = document.createElement('div');
    //     rownew.className = 'row w-100';
    //     rownew.innerHTML = `
    //         <div class="col-md-12">
    //             <div class="row">
    //                 <div class="col-md-6">
    //                     <div class="form-group">
    //                         <label>Nama</label>
    //                         <select id="warga${warga}" class="form-control js-example-basic-single" name="keluarga[]">
    //                             <option selected disabled value="AL">Type to search</option>
    //                         </select>
    //                     </div>
    //                 </div>
    //                 <div class="col-md-5">
    //                     <div class="form-group">
    //                         <label>Dasawisma</label>
    //                         <select class="form-control" name="status[]">
    //                             <option value="kepala-keluarga">Kepala Keluarga</option>
    //                         </select>
    //                     </div>
    //                 </div>
    //                 <div class="col-md-1 d-flex align-items-center">
    //                     <button onclick='onDelete(${warga})' class="btn btn-danger btn-sm mt-2">delete</button>
    //                 </div>
    //             </div>
    //         </div>
    //     `;
    //     container.appendChild(rownew);

    //     var selectElement = document.getElementById(`warga${warga}`);
    //     // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
    //     if (data) {
    //         data.forEach(function(item) {
    //             var option = document.createElement('option');
    //             option.value = item.id;
    //             option.textContent = item.nama_kepala_keluarga + ' - ' + item.nik_kepala_keluarga;
    //             selectElement.appendChild(option);
    //         });
    //     }
    //     selectElement.selectize();
    //     warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    // });

    document.getElementById('addRow').addEventListener('click', function() {
        var container = document.getElementById('containerz');
        var rownew = document.createElement('div');
        rownew.className = 'row w-100';
        rownew.innerHTML = `
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <select id="warga${warga}" class="form-control js-example-basic-single" name="keluarga[]">
                                <option selected disabled value="">Type to search</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Dasawisma</label>
                            <select class="form-control" name="status[]">
                                <option value="kepala-keluarga">Kepala Keluarga</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button onclick='onDelete(${warga})' class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(rownew);

        var selectElement = document.getElementById(`warga${warga}`);
        var selectizeInstance = $(selectElement).selectize({
            // Konfigurasi opsional selectize di sini
        });

        // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
        if (data) {
            data.forEach(function(item) {
                selectizeInstance[0].selectize.addOption({value: item.id, text: item.nama_kepala_keluarga + ' - ' + item.nik_kepala_keluarga});
            });
        }

        warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    });


    function onDelete(id) {
        var elementToRemove = document.getElementById(`warga${id}`).closest('.row');
        elementToRemove.parentNode.removeChild(elementToRemove);
    }

    </script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <script>
        $(document).ready(function() {
            $('.select-state').selectize();
        });
    </script>
@endpush
