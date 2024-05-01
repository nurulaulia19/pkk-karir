@extends('kader.layout')

@section('title', 'Edit Data Rumah Tangga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Edit Data Rumah Tangga')
@section('container')
    <div class="container">
        <ul class="nav nav-tabs" id="dataKeluargaTabs" role="tablist">
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
        <form action="{{ route('data_rumah_tangga.update', $krt->id, ['id' => $krt->id]) }}" method="POST">
            @csrf
            @method('PUT')
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
                                                <input type="text" class="form-control @error('dusun') is-invalid @enderror" name="dusun" id="dusun" placeholder="Masukkan Nama Dusun" value="{{ old('dusun', $krt->dusun) }}">
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
                                                <label>Periode</label>
                                                <select class="form-control" id="periode" name="periode" readonly>
                                                    {{-- Tampilkan opsi select dengan nilai default dari properti periode --}}
                                                    <option value="{{ $krt->periode }}" selected>{{ $krt->periode }}</option>
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

                                                     <option value="{{ $krt->periode }}" selected>{{ $krt->periode }}</option>
                                                 </select>
                                             </div>
                                         </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" data-action="next" class="btn btn-primary">Next</button>
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

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row" id="container">
                                @foreach ($krt->anggotaRT as $index => $item)
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <select name="keluarga[]" id="js-example-basic-multiple" class="form-control js-example-basic-single">

                                                        @foreach ($krt->anggotaRT as $hasKeluarga)
                                                            <option value="{{ $hasKeluarga->keluarga->id }}" {{ $item->keluarga->id == $hasKeluarga->keluarga->id ? 'selected' : '' }}>
                                                                {{ $hasKeluarga->keluarga->nama_kepala_keluarga }}
                                                            </option>
                                                        @endforeach


                                                        {{-- @foreach ($item->keluarga as $keluarga)
                                                            <option value="{{ $keluarga->id }}" {{ $item->keluarga->id == $keluarga->id ? 'selected' : '' }}>
                                                                {{ $keluarga->warga->nama }} - {{ $keluarga->warga->no_ktp }}
                                                            </option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('nama_kepala_rumah_tangga')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group ">
                                                    <label>Status</label>
                                                    <select class="form-control" id="id_dasawisma" name="status[]">
                                                        @if ($index == 0)
                                                            <option selected value="kepala-rumah-tangga">Kepala Rumah Tangga</option>
                                                        @else
                                                        <option selected value="kepala-keluarga">Kepala Keluarga</option>

                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-center">
                                                <a href="{{route('rumah-delete-keluarga',['id' =>$item->id ])}}" class="btn btn-danger btn-sm mt-2">delete</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-end">
                                <button id="addRow" type="button" class="btn btn-primary">ADD</button>

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
                                                    <option value=1 {{ old('kriteria_rumah_sehat', $krt->kriteria_rumah_sehat) == 1 ? 'selected' : '' }}>Sehat</option>
                                                    <option value=0 {{ old('kriteria_rumah_sehat', $krt->kriteria_rumah_sehat) == 0 ? 'selected' : '' }}>Kurang Sehat</option>
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
                                                <label>Memiliki Tempat Pembuangan Sampah</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="punya_tempat_sampah" value=1 class="form-check-input" {{ old('punya_tempat_sampah', $krt->punya_tempat_sampah) == 1 ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="punya_tempat_sampah" value=0 class="form-check-input" {{ old('punya_tempat_sampah', $krt->punya_tempat_sampah) == 0 ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                            </div>
                                            @error('punya_tempat_sampah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group @error('saluran_pembuangan_air_limbah') is-invalid @enderror">
                                                {{-- pilih punya saluran pembuangan air limbah --}}
                                                <label>Mempunyai Saluran Pembuangan Air Limbah</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="saluran_pembuangan_air_limbah" value=1 class="form-check-input" {{ old('saluran_pembuangan_air_limbah', $krt->saluran_pembuangan_air_limbah) == 1 ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="saluran_pembuangan_air_limbah" value=0 class="form-check-input" {{ old('saluran_pembuangan_air_limbah', $krt->saluran_pembuangan_air_limbah) == 0 ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                            </div>
                                            @error('saluran_pembuangan_air_limbah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group @error('tempel_stiker') is-invalid @enderror">
                                                {{-- pilih stiker --}}
                                                <label>Menempel Stiker P4K</label><br>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="tempel_stiker" value=1 class="form-check-input" {{ old('tempel_stiker', $krt->tempel_stiker) ? 'checked' : '' }}>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="tempel_stiker" value=0 class="form-check-input" {{ !old('tempel_stiker', $krt->tempel_stiker) ? 'checked' : '' }}>Tidak
                                                    </label>
                                                </div>
                                            </div>
                                            @error('tempel_stiker')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group @error('punya_jamban') is-invalid @enderror">
                                                <label>Punya Jamban?</label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_ya" value="1" @if(old('punya_jamban', $krt->punya_jamban) == 1) checked @endif>
                                                            <label class="form-check-label" for="punya_jamban_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="punya_jamban" id="punya_jamban_tidak" value="0" @if(old('punya_jamban', $krt->punya_jamban) == 0) checked @endif>
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
                                            <div class="form-group">
                                                <label>Sumber Air:</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_pdam" name="sumber_air_pdam" value="1" @if(old('sumber_air_pdam', $krt->sumber_air_pdam) == 1) checked @endif>
                                                    <label class="form-check-label" for="sumber_air_pdam">PDAM</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_sumur" name="sumber_air_sumur" value="1" @if(old('sumber_air_sumur', $krt->sumber_air_sumur) == 1) checked @endif>
                                                    <label class="form-check-label" for="sumber_air_sumur">Sumur</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sumber_air_lainnya" name="sumber_air_lainnya" value="1" @if(old('sumber_air_lainnya', $krt->sumber_air_lainnya) == 1) checked @endif>
                                                    <label class="form-check-label" for="sumber_air_lainnya">Lainnya</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{-- <button type="button" data-action="next" class="btn btn-primary">Next</button> --}}
                            <button type="submit" class="ml-2 btn btn-success">Edit</button>

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
                            <td>Dasa Wisma</td>
                            <td>Di isi sesuai dengan nama dasawisma yang diikuti warga yang bersangkutan</td>

                        </tr>
                        <tr>
                            <td>Nama Kepala Keluarga</td>
                            <td>Di isi dengan nama Kepala Rumah Tangga pada rumah yang didata.
                                Kepala Rumah Tangga adalah yang bertanggung jawab atas segala sesuatu yang terkait dengan
                                kegiatan di dalam rumah yang sedang didata.</td>

                        </tr>
                        <tr>
                            <td>Jumlah Balita</td>
                            <td>Diisi dengan jumlah Balita yang ada pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah PUS (Pasangan Usia Subur)</td>
                            <td>Diisi dengan jumlah Pasangan Usia Subur yang ada pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah WUS (Wanita Usia Subur)</td>
                            <td>Diisi dengan jumlah Wanita Usia Subur yakni Usia antara 14 tahun hingga 50 tahun pada rumah
                                yang sedang didata kecuali ada keterangan khusus. Misalnya terjadi manopouse dini karena
                                penyakit tertentu, dll.</td>
                        </tr>
                        <tr>
                            <td>Jumlah 3 Buta</td>
                            <td>Diisi dengan jumlah anggota rumah yang sedang didata
                                yang mengalami ‘3 Buta’ pada usia diatas 13 tahun (Buta Baca, Buta Tulis, Buta Hitung)</td>
                        </tr>
                        <tr>
                            <td>Jumlah Ibu Hamil</td>
                            <td>Diisi dengan jumlah ibu hamil pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Ibu Menyusui</td>
                            <td>Diisi dengan jumlah ibu yang sedang menyusui bayi pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Lansia</td>
                            <td>Diisi dengan jumlah orang tua lanjut usia pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Kebutuhan Khusus</td>
                            <td>Diisi dengan jumlah anggota keluarga berkebutuhan khusus pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Stiker P4K (Program Perencanaan Persalinan dan Pencegahan Komplikasi)</td>
                            <td>Stiker P4K berisi data tentang : nama ibu hamil, taksiran persalinan, penolong persalinan,
                                tempat persalinan, pendamping persalinan, transport yang digunakan dan calon donor darah.
                            </td>
                        </tr>
                        <tr>
                            <td>Aktivitas UP2K ( Upaya Peningkatan Pendapatan Keluarga )</td>
                            <td>UP2K ( Upaya Peningkatan Pendapatan Keluarga ) adalah merupakan salah satu program
                                penanggulangan kemiskinan khususnya bagi kaum perempuan.</td>
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

    {{-- <script>
        $(document).ready(function() {
            $('#id_kecamatan').on('change', function() {
                var categoryID = $(this).val();
                console.log('cek data kecamatan');
                if (categoryID) {
                    console.log('cek get data desa');

                    $.ajax({
                        url: '/getDesa/' + categoryID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log('sukses cek data desa');

                            if (data) {
                                $('#id_desa').empty();
                                $('#id_desa').append(
                                    '<option value="" hidden>Pilih Desa</option>');
                                $.each(data, function(key, desas) {
                                    $('select[name="id_desa"]').append(
                                        '<option value="' + key + '">' + desas
                                        .nama_desa + '</option>');
                                });
                            } else {
                                $('#id_desa').empty();
                            }
                        }
                    });
                } else {
                    $('#id_desa').empty();
                }
            });

            $(document).on('click', '[data-action="next"]', function(e) {
                var $active = $('#dataKeluargaTabs .active');
                var hasError = false;

                $($active.attr('href')).find('[name]').each(function() {
                    if ((!$(this).prop('disabled') || !$(this).prop('readonly')) && !$(this)
                        .val()) {
                        $(this).addClass('is-invalid');
                        hasError = true;
                    }
                });
                if (!hasError) {
                    $active.parent().next().find('a').click();
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            // Tangkap klik pada tombol "Next" dengan data-action="next"
            $(document).on('click', '[data-action="next"]', function (e) {
                e.preventDefault(); // Menghentikan perilaku default dari tombol

                // Cari tab yang sedang aktif
                var $activeTab = $('.nav-link.active');

                // Ambil tab berikutnya dalam daftar tab
                var $nextTab = $activeTab.parent().next().find('.nav-link');

                // Periksa apakah masih ada tab berikutnya
                if ($nextTab.length > 0) {
                    // Aktifkan tab berikutnya
                    $nextTab.tab('show');
                } else {
                    // Jika tidak ada tab berikutnya, kembalikan ke tab pertama (opsional)
                    var $firstTab = $('.nav-link').first();
                    $firstTab.tab('show');
                }
            });
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
        document.getElementById('addRow').addEventListener('click', function() {
            var container = document.getElementById('container');
            var rownew = document.createElement('div');
            rownew.className = 'row w-100';
            rownew.innerHTML = `
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <select id="warga${warga}" class="form-control js-example-basic-single" name="keluarga[]">
                                    <option selected disabled value="AL">Type to search</option>
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
                            <button onclick='onDelete(${warga})' class="btn btn-danger btn-sm mt-2">delete</button>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(rownew);

            var selectElement = document.getElementById(`warga${warga}`);
            // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
            if (data) {
                data.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama_kepala_keluarga;
                    selectElement.appendChild(option);
                });
            }
            warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
        });
        function onDelete(id) {
            var elementToRemove = document.getElementById(`warga${id}`).closest('.row');
            elementToRemove.parentNode.removeChild(elementToRemove);
        }

    </script>

@endpush
