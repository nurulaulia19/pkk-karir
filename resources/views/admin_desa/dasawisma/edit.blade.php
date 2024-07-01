@extends('admin_desa.layout')

@section('title', 'Edit Data Dasawisma | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Edit Data Dasawisma')
@section('container')
    <div class="container">
        <ul class="nav nav-tabs" id="dataDasawismaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dasawisma-tab" data-toggle="tab" href="#dasawisma"
                    role="tab" aria-controls="dasawisma" aria-selected="true">Data Dasa Wisma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="kader-tab" data-toggle="tab" href="#kader" role="tab"
                    aria-controls="kader" aria-selected="false">Data Kader</a>
            </li>
        </ul>
        <form action="{{ url('data_dasawisma', $data_dasawisma->id) }}" enctype="multipart/form-data" method="POST">
            @method('PUT')
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
            <div class="tab-content" id="dasawisma-tab">
                <div class="tab-pane fade show active" id="dasawisma" role="tabpanel" aria-labelledby="dasawisma-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Nama Dasawisma</label>
                                        <input type="text"
                                            class="form-control @error('nama_dasawisma') is-invalid @enderror"
                                            name="nama_dasawisma" id="nama_dasawisma" placeholder="Isi Nama Dasawisma"
                                            value="{{ $data_dasawisma->nama_dasawisma }}" required>
                                        @error('nama_dasawisma')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Alamat Dasawisma</label>
                                        {{-- nama Alamat --}}
                                        <input type="text"
                                            class="form-control @error('alamat_dasawisma') is-invalid @enderror"
                                            name="alamat_dasawisma" id="alamat_dasawisma" placeholder="Isi Alamat Dasawisma"
                                            value="{{ $data_dasawisma->alamat_dasawisma }}" required>
                                        @error('alamat_dasawisma')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>RW</label>
                                        <select class="form-control" name="id_rw" id="rw" required>
                                            <option value="" selected disabled>Pilih RW</option>
                                            @foreach ($rws as $rw)
                                                <option value="{{ $rw->id }}"
                                                    {{ $rw->id == $data_dasawisma->id_rw ? 'selected' : '' }}>
                                                    {{ $rw->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>RT</label>
                                        <select class="form-control" name="id_rt" id="rt" required>
                                            <option value="" selected disabled>Pilih RT</option>
                                            @foreach ($rts as $rt)
                                                <option value="{{ $rt->id }}"
                                                    {{ $rt->id == $data_dasawisma->id_rt ? 'selected' : '' }}>
                                                    {{ $rt->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-3">
                                    <div class="form-group @error('dusun') is-invalid @enderror">
                                        <label for="exampleFormControlSelect1">Dusun</label>
                                        <select class="form-control" id="dusun" name="dusun">
                                            <option value="0" selected>Tidak Memiliki Dusun</option>
                                            @foreach ($dusun as $c)
                                                <option {{ $data_dasawisma->dusun == $c->id ? 'selected' : '' }}
                                                    value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dusun')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ old('dusun') }} {{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-group @error('status') is-invalid @enderror">
                                        <label>Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status"
                                            required>
                                            <option hidden>Pilih Status Dasawisma</option>
                                            <option value=1 {{ $data_dasawisma->status == 1 ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value=0 {{ $data_dasawisma->status == 0 ? 'selected' : '' }}>Tidak Aktif
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nama Desa</label>
                                        <input type="text" readonly class="form-control" name="id_desa" id="id_desa"
                                            placeholder="Masukkan Nama Kader" required
                                            value="{{ Auth::user()->desa->nama_desa }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nama Kecamatan</label>
                                        <input type="text" readonly class="form-control" name="id_kecamatan"
                                            id="id_kecamatan" placeholder="Masukkan Nama Kader" required
                                            value="{{ Auth::user()->kecamatan->nama_kecamatan }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group @error('periode') is-invalid @enderror">
                                        <label>Periode</label>
                                        <input type="text" readonly class="form-control" id="periode"
                                            name="periode" value="{{ $data_dasawisma->periode }}" required>
                                    </div>
                                    @error('periode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" data-action="next" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kader" role="tabpanel" aria-labelledby="kader-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Masukkan Nama Kader" required
                                    value="{{ $kader->name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ old('name') }} {{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" placeholder="Masukkan Email Pengguna"
                                    value="{{ $kader->email }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{ old('email') }} {{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="Masukkan Password Jika Ingin diubah">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ old('password') }} {{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>User Type</label>
                                <input type="text" readonly
                                    class="form-control @error('user_type') is-invalid @enderror" name="user_type"
                                    id="user_type" value="kader_dasawisma" required>
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama Desa</label>
                                <input type="text" readonly class="form-control" name="id_desa" id="id_desa"
                                    placeholder="Masukkan Nama Kader" required
                                    value="{{ Auth::user()->desa->nama_desa }}">
                            </div>
                            <div class="form-group">
                                <label>Nama Kecamatan</label>
                                <input type="text" readonly class="form-control" name="id_kecamatan"
                                    id="id_kecamatan" placeholder="Masukkan Nama Kader" required
                                    value="{{ Auth::user()->kecamatan->nama_kecamatan }}">
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto Profil</label>
                                <!-- Tampilkan foto profil sebelumnya jika ada -->
                                <input name="foto" type="file" class="form-control-file" id="foto">
                                @if ($kader->foto)
                                    <img src="{{ asset('uploads/' . $kader->foto) }}" class="img-thumbnail"
                                        alt="Foto Profil Kader" style="max-width: 200px;">
                                @else
                                    <p>Tidak ada foto profil tersedia</p>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn"
                                style="background-color: #50A3B9; color:white">Edit</button>
                            <a href="/data_dasawisma" class="btn btn-outline-danger">
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
    <script>
        $(document).on('click', '[data-action="next"]', function(e) {
            var $active = $('#dataDasawismaTabs .active'); // Menggunakan ID yang sesuai
            var hasError = false;

            // Cek apakah ada input yang kosong di tab aktif
            $($active.attr('href')).find('[name]').each(function() {
                if ((!$(this).prop('disabled') || !$(this).prop('readonly')) && !$(this).val()) {
                    $(this).addClass('is-invalid');
                    hasError = true;
                }
            });

            // Jika tidak ada error, pindahkan ke tab berikutnya
            if (!hasError) {
                $active.parent().next().find('a').click();
            }
        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#rw').on('change', function() {
                var rwId = $(this).val();
                if (rwId) {
                    $.ajax({
                        url: '{{ route('get.rt.by.rw') }}', // Sesuaikan dengan rute yang Anda gunakan
                        type: 'GET',
                        data: {
                            rw_id: rwId
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#rt').empty();
                            $('#rt').append(
                                '<option value="" selected disabled>Pilih RT</option>');
                            $.each(data, function(key, value) {
                                $('#rt').append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#rt').empty();
                    $('#rt').append('<option value="" selected disabled>Pilih RT</option>');
                }
            });
        });
    </script>
@endpush
