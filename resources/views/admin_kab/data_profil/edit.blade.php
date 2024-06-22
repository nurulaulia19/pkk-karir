@extends('admin_kab.layout')

@section('title', 'Edit Data Profil Pembina dan Ketua | Admin PKK Kab. Indramayu')

@section('bread', 'Edit Data Profil Pembina dan Ketua')
@section('container')

    <div class="col-12 col-xl-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header" style="background-color: #50A3B9; color:white">
                <h3 class="card-title">Edit Data Profil</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('profile-pembina-ketua.update', $profile->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap"
                                    value="{{ $profile->nama_lengkap }}" required>

                                @error('nama_lengkap')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    name="tempat_lahir" id="tempat_lahir" value="{{ $profile->tempat_lahir }}"  placeholder="Masukkan Tempat Lahir" required>
                                @error('tempat_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    name="tanggal_lahir" id="tanggal_lahir" value="{{ $profile->tanggal_lahir }}" required>
                                @error('tanggal_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                                    id="jabatan" required>
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    <option value="Ketua" {{ $profile->jabatan == 'Ketua' ? 'selected' : '' }}>Ketua
                                    </option>
                                    <option value="Pembina" {{ $profile->jabatan == 'Pembina' ? 'selected' : '' }}>Pembina
                                    </option>
                                </select>
                                @error('jabatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="masa_jabatan_mulai">Tahun Jabatan Mulai</label>
                                <input type="text" class="form-control @error('masa_jabatan_mulai') is-invalid @enderror"
                                    name="masa_jabatan_mulai" id="masa_jabatan_mulai" placeholder="Masa Jabatan Mulai"
                                    value="{{ $profile->masa_jabatan_mulai }}" required>
                                @error('masa_jabatan_mulai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="masa_jabatan_akhir">Tahun Jabatan Akhir</label>
                                <input type="text" class="form-control @error('masa_jabatan_akhir') is-invalid @enderror"
                                    name="masa_jabatan_akhir" id="masa_jabatan_akhir" placeholder="Masa Jabatan Akhir"
                                    value="{{ $profile->masa_jabatan_akhir }}" required>
                                @error('masa_jabatan_akhir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="riwayat_pendidikan">Riwayat Pendidikan</label>
                                <div id="riwayat_pendidikan_container">
                                    @foreach (explode(', ', $profile->riwayat_pendidikan) as $index => $pendidikan)
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control selectPendidikan"
                                                name="riwayat_pendidikan[]" placeholder="Masukkan Riwayat Pendidikan"
                                                value="{{ $pendidikan }}" required>
                                            <div class="input-group-append">
                                                @if ($index >= 2)
                                                    <button class="btn btn-danger deleteButton" type="button"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('riwayat_pendidikan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2 row d-flex justify-content-end mr-1">
                                    <button type="button" id="addButton" class="btn btn-sm"
                                        style="background-color: #50A3B9; color:white"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="riwayat_pekerjaan">Riwayat Pekerjaan</label>
                                <div id="riwayat_pekerjaan_container">
                                    @foreach (explode(', ', $profile->riwayat_pekerjaan) as $index => $pekerjaan)
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control selectPekerjaan"
                                                name="riwayat_pekerjaan[]" placeholder="Masukkan Riwayat Pekerjaan"
                                                value="{{ $pekerjaan }}">
                                            <div class="input-group-append">
                                                @if ($index >= 1)
                                                    <button class="btn btn-danger deleteButton"
                                                        type="button"><i class="fas fa-trash"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('riwayat_pekerjaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mt-2 d-flex justify-content-end mr-1">
                                    <button type="button" id="addPekerjaanButton" class="btn btn-sm"
                                        style="background-color: #50A3B9; color:white"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input accept="image/*" type="file"
                            class="form-control-file @error('foto') is-invalid @enderror" id="foto" name="foto">
                        @if ($profile->foto)
                            <div class="mt-2">
                                <p>Foto saat ini:</p>
                                <img id="currentPhoto"
                                    src="{{ $profile->foto ? asset('uploads/' . $profile->foto) : asset('assets/img/profile.png') }}"
                                    alt="Current Photo" style="max-width: 100px;">
                            </div>
                        @endif
                        @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Simpan
                        Perubahan</button>
                    <a href="/profile-pembina-ketua" class="btn btn-outline-danger">
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
            // Tombol Tambah Riwayat Pendidikan
            $('#addButton').click(function() {
                var newInput =
                    '<div class="input-group mt-2">' +
                    '<input type="text" class="form-control selectPendidikan" name="riwayat_pendidikan[]" placeholder="Masukkan Riwayat Pendidikan" required>' +
                    '<div class="input-group-append">' +
                    '<button class="btn btn-danger deleteButton" type="button"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>';
                $('#riwayat_pendidikan_container').append(newInput);
            });

            // Tombol Tambah Riwayat Pekerjaan
            $('#addPekerjaanButton').click(function() {
                var newInput =
                    '<div class="input-group mt-2">' +
                    '<input type="text" class="form-control selectPekerjaan" name="riwayat_pekerjaan[]" placeholder="Masukkan Riwayat Pekerjaan" required>' +
                    '<div class="input-group-append">' +
                    '<button class="btn btn-danger deleteButton" type="button"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>';
                $('#riwayat_pekerjaan_container').append(newInput);
            });

            // Handle event untuk menghapus inputan
            $(document).on('click', '.deleteButton', function() {
                $(this).closest('.input-group').remove();
            });
            $(document).ready(function() {
                $('#foto').change(function() {
                    $('#foto').change(function(e) {
                        var file = e.target.files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#currentPhoto').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(file);
                    });
                });
            });


            $('#riwayat_pendidikan_container').on('click', '.deleteButton', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
@endpush