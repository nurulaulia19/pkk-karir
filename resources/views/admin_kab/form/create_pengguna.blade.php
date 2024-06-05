@extends('admin_kab.layout')

@section('title', 'Tambah Data Pengguna | Admin Kabupaten PKK Kab. Indramayu')

@section('bread', 'Tambah Data Pengguna')
@section('container')

    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Pengguna</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ route('data_pengguna_super.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Masukkan Nama Kader" required value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="Masukkan Email" required value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder="Masukkan Password" required value="{{ old('password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group @error('user_type') is-invalid @enderror">
                        <label>User Type</label>
                        <select class="form-control @error('user_type') is-invalid @enderror" name="user_type" id="user_type">
                            <option selected disabled>Pilih User Type</option>
                            @foreach ($user_type as $key => $val)
                                @if ($key == old('user_type'))
                                    <option value="{{ $key }}" selected>{{ $val }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('user_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror


                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kecamatan</label>
                                <select class="form-control @error('id_kecamatan') is-invalid @enderror" id="id_kecamatan"
                                    name="id_kecamatan">
                                    {{-- Pilih Kecamatan --}}
                                    <option selected disabled> Pilih Kecamatan</option>
                                    {{-- @foreach ($kategori as $key => $val)
                            @if ($key == old('nama_kategori'))
                            <option value="{{ $key }}" selected>{{ $val }}</option>
                            @else
                            <option value="{{ $key }}">{{ $val }}</option>
                            @endif
                        @endforeach --}}
                                    @foreach ($kec as $item)
                                        <option {{ old('id_kecamatan') == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                    @endforeach
                                    {{-- @foreach ($kec as $item)
                            <option value="{{ $item->id }}" @if ($item->id == old('id_kecamatan')) selected @endif>
                                {{ $item->nama_kecamatan }}
                            </option>
                        @endforeach --}}

                                </select>
                                @error('id_kecamatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="desaId" style="display: none">
                                <label>Nama Desa</label>
                                <select class="form-control @error('id_desa') is-invalid @enderror" id="id_desa"
                                    name="id_desa">
                                </select>
                                @error('id_desa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input name="foto" type="file" class="form-control-file" id="foto"
                            accept=".img, .jpg, .jpeg, .png" value="{{ old('foto') }}">
                        {{-- <img src="{{asset('gambar/'. $c->logo)}}" class="img-thumbnail" width="100px"> --}}
                        {{-- <input name="logo" type="hidden" name="hidden_image" value="{{asset('gambar/'. $c->logo)}}" class="form-control-file" id="hidden_image"> --}}
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="/data_pengguna_super" class="btn btn-outline-primary">
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
        document.addEventListener("DOMContentLoaded", function() {

            var id_kecamatan = "{{ old('id_kecamatan') }}";
            if (id_kecamatan) {
                        console.log('cek get data desa');

                        $.ajax({
                            url: '/getDesa/' + id_kecamatan,
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
                                        '<option selected disabled>Pilih Desa</option>'
                                        );
                                    var old_id_desa =
                                    "{{ old('id_desa') }}"; // Ambil nilai lama dari old

                                    $.each(data, function(key, desas) {
                                        var selected = (old_id_desa == desas
                                            .id) ? 'selected' :
                                            ''; // Periksa apakah ini adalah nilai lama
                                        $('select[name="id_desa"]').append(
                                            '<option value="' + desas.id +
                                            '" ' + selected + '>' + desas
                                            .nama_desa + '</option>');
                                    });
                                } else {
                                    $('#id_desa').empty();
                                }

                            }
                        });
                    } 

                    
            var userType = document.getElementById('user_type').value;
            $(document).ready(function() {

                $('#user_type').on('change', function() {
    var userType = document.getElementById('user_type').value;
    var desaId = document.getElementById('desaId');
    if (userType == 'admin_desa') {
        desaId.style.display = 'block'; // Menampilkan elemen desaId
    } else {
        desaId.style.display = 'none'; // Menyembunyikan elemen desaId jika userType tidak sama dengan 'admin_desa'
    }
});




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
                                        '<option selected disabled>Pilih Desa</option>'
                                        );
                                    var old_id_desa =
                                    "{{ old('id_desa') }}"; // Ambil nilai lama dari old

                                    $.each(data, function(key, desas) {
                                        var selected = (old_id_desa == desas
                                            .id) ? 'selected' :
                                            ''; // Periksa apakah ini adalah nilai lama
                                        $('select[name="id_desa"]').append(
                                            '<option value="' + desas.id +
                                            '" ' + selected + '>' + desas
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
            });
        });
    </script>
@endpush
