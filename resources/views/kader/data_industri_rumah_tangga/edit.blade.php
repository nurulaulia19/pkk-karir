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

      <form action="{{ url('data_industri', $data_industri->id) }}" method="POST">
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
                        <label>Nama</label>
                        <select class="form-control" name="warga_id">
                                <option value="{{ $data_industri->warga->id }}" selected>
                                    {{ $data_industri->warga->nama }} - {{ $data_industri->warga->no_ktp }}
                                </option>
                        </select>

                        @error('warga_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" id="nama_kategori" name="nama_kategori">
                            {{-- pilih kategori --}}
                            <option hidden> Pilih Kategori</option>
                            <option value="Pangan" {{ $data_industri->nama_kategori == "Pangan" ? 'selected' : '' }}>Pangan</option>
                            <option value="Konveksi" {{ $data_industri->nama_kategori == "Konveksi" ? 'selected' : '' }}>Konveksi</option>
                            <option value="Sandang" {{ $data_industri->nama_kategori == "Sandang" ? 'selected' : '' }}>Sandang</option>
                            <option value="Jasa" {{ $data_industri->nama_kategori == "Jasa" ? 'selected' : '' }}>Jasa</option>
                            <option value="Lain-lain" {{ $data_industri->nama_kategori == "Lain-lain" ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Komoditi</label>
                        {{-- nama Komoditi --}}
                        <input type="text" class="form-control @error('komoditi') is-invalid @enderror" name="komoditi" id="komoditi" placeholder="Masukkan Komoditi" value="{{ucfirst(old('komoditi', $data_industri->komoditi)) }}">
                        @error('komoditi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Volume</label>
                        {{-- volume Komoditi --}}
                        <input type="number" min="0" class="form-control @error('volume') is-invalid @enderror" name="volume" id="volume" placeholder="Masukkan Volume" value="{{ucfirst(old('volume', $data_industri->volume))}}">
                        @error('volume')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Periode</label>
                        {{-- pilih periode --}}
                        <select style="cursor:pointer;" class="form-control" id="periode" name="periode">
                            <option value="{{ $data_industri->periode }}" {{ $data_industri->periode ? 'selected' : '' }}>{{ $data_industri->periode }}</option>
                                <?php
                                $year = date('Y');
                                $min = $year ;
                                    $max = $year + 20;
                                for( $i=$min; $i<=$max; $i++ ) {
                                echo '<option value='.$i.'>'.$i.'</option>';
                            }?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group @error('id_user') is-invalid @enderror">
                        {{-- nama kader --}}
                        @foreach ($kad as $c)
                            <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{$c->id}}">
                            <input type="hidden" disabled class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{ $c->name }}">
                        @endforeach
                    </div>
                    @error('id_user')
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