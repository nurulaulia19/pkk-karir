@extends('kader.layout')

@section('title', 'Edit Data Industri Rumah Tangga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Edit Data Industri Rumah Tangga')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Industri Rumah Tangga</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ url('data_industri', ['id' => $keluarga->id]) }}" method="POST">
        @method('PUT')
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
                        <label for="exampleFormControlSelect1">Desa</label>
                        {{-- nama desa --}}
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
                        {{-- nama Kecamatan --}}
                        @foreach ($kec as $c)
                        <input type="hidden" class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Desa" value="{{$c->id}}">
                        <input type="text" disabled class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Desa" value="{{ $c->nama_kecamatan }}">

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
                    <div class="form-group">
                        <label>Pilih Kepala Keluarga</label>
                        <select class="form-control" name="keluarga_id">
                                <option value="{{ $keluarga->id }}" selected>
                                    {{ $keluarga->nama_kepala_keluarga }} - {{ $keluarga->nik_kepala_keluarga }}
                                </option>
                        </select>
                        @error('keluarga_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" id="kategori_industri_rumah_id" name="kategori_industri_rumah_id">
                            {{-- pilih kategori --}}
                            <option hidden> Pilih Kategori</option>
                            @foreach ($kategoriIndustri as $item)
                                <option value="{{ $item->id }}" {{ $keluarga->industri_id == $item->id ? 'selected' : ''  }} >{{ $item->nama_kategori }}</option>

                            @endforeach
                            {{-- <option value="Pangan" {{ $data_industri->nama_kategori == "Pangan" ? 'selected' : '' }}>Pangan</option>
                            <option value="Konveksi" {{ $data_industri->nama_kategori == "Konveksi" ? 'selected' : '' }}>Konveksi</option>
                            <option value="Sandang" {{ $data_industri->nama_kategori == "Sandang" ? 'selected' : '' }}>Sandang</option>
                            <option value="Jasa" {{ $data_industri->nama_kategori == "Jasa" ? 'selected' : '' }}>Jasa</option>
                            <option value="Lain-lain" {{ $data_industri->nama_kategori == "Lain-lain" ? 'selected' : '' }}>Lain-lain</option> --}}
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
            </div>

        </div>

        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
          <a href="/data_industri" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection


@push('script-addon')
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
@endpush
