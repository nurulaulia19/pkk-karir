@extends('kader.layout')

@section('title', 'Edit Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Edit Data Keluarga')
@section('container')

<div class="container">
    <ul class="nav nav-tabs" id="dataKeluargaTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="dasawisma-tab" data-toggle="tab" href="#dasawisma" role="tab" aria-controls="dasawisma" aria-selected="true">Data Dasa Wisma</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false">Data Keluarga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="kondisi-keluarga-tab" data-toggle="tab" href="#kondisi-keluarga" role="tab" aria-controls="kondisi-keluarga" aria-selected="false">Data Kondisi Keluarga</a>
        </li>
    </ul>

    <form action="{{ url('data_keluarga', $data_keluarga->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dasawisma" role="tabpanel" aria-labelledby="dasawisma-tab">
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
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Dasa Wisma</label>
                                            {{-- <input type="text" class="form-control @error('dasa_wisma') is-invalid @enderror" name="dasa_wisma" id="dasa_wisma" placeholder="Masukkan Nama Dasa Wisma" value="{{ old('dasa_wisma') }}"> --}}
                                            <select class="form-control" id="id_dasawisma" name="id_dasawisma">
                                                {{-- nama dasa wisma --}}
                                                @foreach ($dasawisma as $c)
                                                    <option value="{{$c->id}}" {{ $c->id === $c->id_dasawisma ? 'selected' : '' }}>{{ $c->nama_dasawisma }}</option>
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
                                            <label for="exampleFormControlSelect1">RT</label>
                                            <input type="number" min="1" class="form-control @error('rt') is-invalid @enderror" name="rt" id="rt" placeholder="Masukkan No. RT" value="{{ old('rt', $data_keluarga->rt ) }}">

                                                {{-- <select class="form-control" id="rt" name="rt"> --}}
                                                    {{-- nomor rt --}}
                                                    {{-- <option value="" hidden> Pilih RT</option>
                                                    @foreach ($warga as $c)
                                                        <option value="{{$c->id}}">{{ $c->rt }}</option>
                                                    @endforeach
                                                </select> --}}
                                        </div>
                                        @error('rt')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group @error('rw') is-invalid @enderror">
                                            <label for="exampleFormControlSelect1">RW</label>
                                            <input type="number" min="1" class="form-control @error('rw') is-invalid @enderror" name="rw" id="rw" placeholder="Masukkan No. RW" value="{{ old('rw', $data_keluarga->rw ) }}">

                                            {{-- <select class="form-control " id="rw" name="rw"> --}}
                                                {{-- nama rw --}}
                                                {{-- <option value="" hidden> Pilih RW</option>
                                                @foreach ($warga as $c)
                                                    <option value="{{$c->id}}">{{ $c->rw }}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                        @error('rw')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group @error('rw') is-invalid @enderror">
                                            <label for="exampleFormControlSelect1">Dusun</label>
                                            <input type="text" class="form-control @error('dusun') is-invalid @enderror" name="dusun" id="dusun" placeholder="Masukkan Nama Dusun" value="{{ old('dusun', $data_keluarga->dusun) }}">
                                        </div>
                                        @error('dusun')
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
                                        <div class="form-group @error('id_desa') is-invalid @enderror">
                                            <label for="exampleFormControlSelect1">Desa</label>
                                            @foreach ($desas as $c)
                                                <input type="hidden" class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" value="{{$c->id}}">
                                                <input type="text" disabled class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" value="{{ $c->nama_desa }}">

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
                                            <label for="exampleFormControlSelect1">Kecamatan</label>
                                            {{-- nama kecamatan --}}
                                            @foreach ($kec as $c)
                                            <input type="hidden" class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Kecamatan" value="{{$c->id}}">
                                            <input type="text" disabled class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Kecamatan" value="{{ $c->nama_kecamatan }}">

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
                                                <input type="text" readonly class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten" placeholder="Masukkan kabupaten" value="Indramayu">
                                                @error('kabupaten')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Provinsi</label>
                                            {{-- nama provinsi --}}
                                                <input type="text" readonly class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" placeholder="Masukkan Provisni" value="Jawa Barat">
                                                @error('provinsi')
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
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="/data_keluarga" class="btn btn-outline-primary">
                            <span>Batalkan</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
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

                        <div class="row" id="container">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            {{-- <input type="text" class="form-control @error('nama_kepala_rumah_tangga') is-invalid @enderror" name="nama_kepala_rumah_tangga" id="nama_kepala_rumah_tangga" placeholder="Masukkan Nama Kepala Rumah Tangga" value="{{ old('nama_kepala_rumah_tangga') }}"> --}}
                                            <select name="warga[]" id="js-example-basic-multiple"
                                                class="form-control js-example-basic-single" name="user_id[]">
                                                <option selected disabled>Type to search</option>
                                                @foreach ($warga as $warga)
                                                    <option value="{{ $warga->id }}">{{ $warga->nama }}</option>
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
                                            <select class="form-control" id="status" name="status[]">
                                                {{-- <option selected> -- pili status --</option> --}}
                                                <option selected value="kepala-keluarga">Kepala Keluarga</option>
                                                {{-- <option value="ibu">Ibu</option>
                                                <option value="anak">Anak</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                <div class="col-md-6">
                                    <div class="form-group @error('punya_jamban') is-invalid @enderror">
                                        {{-- pilih mempunyai jamban --}}
                                        <label>Mempunyai Jamban Keluarga</label><br>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <input type="radio" aria-label="Radio button for following text input" name="punya_jamban" value="1">Ya
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" class="form-control" aria-label="Text input with radio button" name="jumlah_jamban" placeholder="Jumlah Jamban">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" name="punya_jamban" value="0" class="form-check-input">Tidak
                                                        </label>
                                                    </div>
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="/data_keluarga" class="btn btn-outline-primary">
                            <span>Batalkan</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('script-addon')

<script type="text/javascript">

    $(function() {

      $( "#datepicker" ).datepicker({

             changeMonth: true,

             changeYear: true

         });

    });

       window.onload=function(){

           $('#tgl_lahir').on('change', function() {

               var dob = new Date(this.value);

               var today = new Date();

                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

               $('#umur').val(age);

           });

       }

</script>
<script>
    $(document).ready(function() {
    $('#id_kecamatan').on('change', function() {
       var categoryID = $(this).val();
       console.log('cek data kecamatan');
       if(categoryID) {
        console.log('cek get data desa');

           $.ajax({
               url: '/getDesa/'+categoryID,
               type: "GET",
               data : {"_token":"{{ csrf_token() }}"},
               dataType: "json",
               success:function(data)
               {
                console.log('sukses cek data desa');

                 if(data){
                    $('#id_desa').empty();
                    $('#id_desa').append('<option hidden>Pilih Desa</option>');
                    $.each(data, function(key, desas){
                        $('select[name="id_desa"]').append('<option value="'+ key +'">' + desas.nama_desa+ '</option>');
                    });
                }else{
                    $('#id_desa').empty();
                }
             }
           });
       }else{
         $('#id_desa').empty();
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
            url: "/warga",
            type: "GET",
            success: function(response) {
                console.log(response);
                data = response.warga; // Simpan data warga dalam variabel
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
                            <select id="warga${warga}" class="form-control js-example-basic-single" name="warga[]">
                                <option selected disabled value="AL">Type to search</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status[]">
                                <option disabled selected> -- pilih status -- </option>

                                <option value="ibu">Ibu</option>
                                <option value="anak">Anak</option>
                            </select>
                        </div>
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
                option.textContent = item.nama;
                selectElement.appendChild(option);
            });
        }
        warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    });
</script>
@endpush
