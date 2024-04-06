@extends('kader.layout')

@section('title', 'Tambah Data Kegiatan Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Kegiatan Warga')
@section('container')

    <div class="col-md-10">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Kegiatan Warga</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ route('data_kegiatan.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <h6 style="color: red">* Semua elemen atribut harus diisi</h6>
                    {{-- <h6 style="color: red">* Keterangan Kegiatan Yang diikuti seperti : Keagamaan, PKBN, Pola Asuh Pencegahan KDRT, Pencegahan Traffocking, Narkoba, Pencegahan
                Kejahatan Seksual, Kerja Bakti, Jimpitan, Arisan, Rukun Kematian, Bakti Sosial, BKB, PAUD Sejenis, Paket A, Paket B, Paket C, KF (Keaksaraan Fungsional),
                UP2K, Koperasi</h6> --}}
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
                        <div class="col-md-6">
                            <div class="form-group @error('id_desa') is-invalid @enderror">
                                {{-- nama desa --}}
                                <label for="exampleFormControlSelect1">Desa</label>
                                <input type="text" disabled class="form-control" name="id_desa" id="id_desa"
                                    placeholder="Masukkan Nama Desa" required value="curut">

                                {{-- @foreach ($desas as $c)
                        <input type="hidden" class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{$c->id}}">

                        <input type="text" disabled class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{ $c->nama_desa }}">

                        @endforeach --}}
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
                                    <input type="hidden" class="form-control" name="id_kecamatan" id="id_kecamatan"
                                        placeholder="Masukkan Nama Desa" required value="{{ $c->id }}">
                                    <input type="text" disabled class="form-control" name="id_kecamatan"
                                        id="id_kecamatan" placeholder="Masukkan Nama Desa" required
                                        value="{{ $c->nama_kecamatan }}">
                                @endforeach
                            </div>
                            @error('id_kecamatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- cekuek  --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nama Warga</label>
                                <select class="form-control @error('id_warga') is-invalid @enderror" id="id_warga"
                                    name="id_warga">
                                    {{-- nama warga --}}
                                    <option hidden> Pilih Nama Warga</option>
                                    @foreach ($warga as $c)
                                        <option value="{{ $c->id }}"> {{ $c->id }}-{{ $c->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_warga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- tingting --}}
                    {{-- @dd($keg) --}}
                    <div class="form-group" id="formContainer">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nama_kegiatan">Nama Kegiatan</label>
                                <select class="form-control" id="selectNamaKegiatan" name="nama_kegiatan">
                                    <option value="">Pilih Kegiatan</option>
                                    @foreach ($keg as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="detail_kegiatan">Detail Kegiatan</label>
                                <select class="form-control" id="selectDetailKegiatan" name="detail_kegiatan">
                                    <option value="">Pilih Detail Kegiatan</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="row d-flex justify-content-end mr-1">
                        <button type="button" id="addButton" class="btn btn-primary">add</button>
                    </div>
                    {{-- end tingting --}}



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @error('aktivitas') is-invalid @enderror">
                                <label>Aktivitas</label><br>
                                {{-- Pilih aktivitas --}}
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="aktivitas" value="Ya" class="form-check-input">Ya
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="aktivitas" value="Tidak" class="form-check-input">Tidak
                                    </label>
                                </div>
                            </div>
                            @error('aktivitas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <div class="form-group @error('id_user') is-invalid @enderror">
                                {{-- nama kader --}}
                                {{-- @foreach ($kad as $c)
                            <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{$c->id}}">
                            <input type="hidden" disabled class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{ $c->name }}">
                        @endforeach --}}
                            </div>
                            @error('id_user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{-- nama keterangan --}}
                                <label>Keterangan (Jenis Kegiatan Yang Diikuti)</label>
                                {{-- <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan"> --}}
                                <select class="form-control @error('id_keterangan') is-invalid @enderror" id="id_keterangan"
                                    name="id_keterangan">
                                    {{-- Pilih Kegiatan --}}
                                    {{-- <option hidden> Pilih Keterangan Kegiatan</option> --}}
                                    {{-- @foreach ($keterangan as $key => $val)
                                    @if ($key == old('keterangan'))
                                        <option value="{{ $key }}" selected>{{ $val }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endif
                                @endforeach --}}
                                </select>

                                @error('id_keterangan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @error('periode') is-invalid @enderror">
                                <label>Periode</label>
                                {{-- pilih periode --}}
                                <select style="cursor:pointer;" class="form-control " id="periode" name="periode"
                                    value="{{ old('periode') }}">
                                    <option hidden> Pilih Tahun</option>
                                    <?php
                                    $year = date('Y');
                                    $min = $year;
                                    $max = $year + 20;
                                    for ($i = $min; $i <= $max; $i++) {
                                        echo '<option value=' . $i . '>' . $i . '</option>';
                                    } ?>
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
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="/data_kegiatan" class="btn btn-outline-primary">
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
            $('#id_kategori').on('change', function() {
                var categoryID = $(this).val();
                console.log('cek data kegiatan');
                if (categoryID) {
                    console.log('cek get data keterangan kegiatan');

                    $.ajax({
                        url: '/getKeterangan/' + categoryID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log('sukses cek data desa');

                            if (data) {
                                $('#id_keterangan').empty();
                                $('#id_keterangan').append(
                                    '<option hidden>Pilih Keterangan</option>');
                                $.each(data, function(key, keterangan) {

                                    $('select[name="id_keterangan"]').append(
                                        '<option value="' + keterangan.id + '">' +
                                        keterangan.nama_keterangan + '</option>');
                                });
                            } else {
                                $('#id_keterangan').empty();
                            }
                        }
                    });
                } else {
                    $('#id_keterangan').empty();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectNamaKegiatan').change(function() {
                // alert('marhaban');
                var kegiatanId = $(this).val(); // Ambil nilai id kegiatan yang dipilih
                // alert(kegiatanId);
                // Kirim permintaan AJAX untuk mendapatkan detail kegiatan
                $.ajax({
                    url: "{{ route('detailKegiatanInDesa', ['id' => 1]) }}", // Ganti dengan URL endpoint yang sesuai
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        var detailKegiatanSelect = $('#selectDetailKegiatan');
                        detailKegiatanSelect.empty(); // Kosongkan opsi yang ada sebelumnya

                        // Tambahkan opsi-opsi detail kegiatan ke dalam elemen select
                        $.each(response.data, function(index, detail) {
                            detailKegiatanSelect.append('<option value="' + detail.id +
                                '">' + detail.name + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>


    <script>
        let data; // Variabel untuk menyimpan data warga
        let warga = 1; // Variabel untuk menyimpan nomor select

        // Fungsi untuk melakukan permintaan API sekali saja di awal
        $(document).ready(function() {
            let data; // Variabel untuk menyimpan data kegiatan dan detail kegiatan

            // Fungsi untuk mengambil data kegiatan dan detail kegiatan saat halaman dimuat
            $.ajax({
                url: "{{ route('kegiatanInDesa', ['id' => 1]) }}",
                type: "GET",
                success: function(response) {
                    console.log('Data Kegiatan:', response);
                    data = response.data; // Simpan data kegiatan dan detail kegiatan ke dalam variabel
                    populateNamaKegiatanSelect(); // Panggil fungsi untuk mengisi opsi nama kegiatan
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });

            // Fungsi untuk mengisi opsi "Nama Kegiatan" pada elemen select
            function populateNamaKegiatanSelect() {
                const namaKegiatanSelect = document.querySelector('#namaKegiatanSelect');
                namaKegiatanSelect.innerHTML = ''; // Kosongkan opsi yang ada sebelumnya

                const defaultOptionNamaKegiatan = document.createElement('option');
                defaultOptionNamaKegiatan.value = '';
                defaultOptionNamaKegiatan.textContent = 'Pilih Nama Kegiatan';
                namaKegiatanSelect.appendChild(defaultOptionNamaKegiatan);

                // Tambahkan opsi nama kegiatan berdasarkan data yang tersedia
                if (data) {
                    data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        namaKegiatanSelect.appendChild(option);
                    });
                }
            }

            // Event listener untuk menanggapi perubahan pilihan "Nama Kegiatan"
            $('#namaKegiatanSelect').change(function() {
                const selectedKegiatanId = $(this).val();
                const detailKegiatanSelect = document.querySelector('#detailKegiatanSelect');
                detailKegiatanSelect.innerHTML = ''; // Kosongkan opsi yang ada sebelumnya

                const defaultOptionDetailKegiatan = document.createElement('option');
                defaultOptionDetailKegiatan.value = '';
                defaultOptionDetailKegiatan.textContent = 'Pilih Detail Kegiatan';
                detailKegiatanSelect.appendChild(defaultOptionDetailKegiatan);

                // Tambahkan opsi detail kegiatan berdasarkan kegiatan yang dipilih
                if (data) {
                    const selectedKegiatan = data.find(item => item.id == selectedKegiatanId);
                    if (selectedKegiatan && selectedKegiatan.detail_kegiatan) {
                        selectedKegiatan.detail_kegiatan.forEach(function(detail) {
                            const option = document.createElement('option');
                            option.value = detail.id;
                            option.textContent = detail.nama_detail_kegiatan;
                            detailKegiatanSelect.appendChild(option);
                        });
                    }
                }
            });

            // Event listener untuk tombol "Add"
            const addButton = document.querySelector('#addButton');
            const formContainer = document.querySelector('#formContainer');

            addButton.addEventListener('click', function() {
                // alert('ss');
                // Create new row for nama kegiatan and detail kegiatan
                const newRow = document.createElement('div');
                newRow.className = 'row';

                // Create nama kegiatan select
                const namaKegiatanCol = document.createElement('div');
                namaKegiatanCol.className = 'col-md-6';
                const namaKegiatanLabel = document.createElement('label');
                namaKegiatanLabel.textContent = 'Nama Kegiatan';
                const namaKegiatanSelect = document.createElement('select');
                namaKegiatanSelect.className = 'form-control';
                namaKegiatanSelect.name = 'nama_kegiatan[]'; // Use array notation for multiple inputs
                namaKegiatanSelect.id = 'namaKegiatanSelect'; // Add ID to nama kegiatan select
                namaKegiatanCol.appendChild(namaKegiatanLabel);
                namaKegiatanCol.appendChild(namaKegiatanSelect);

                // Create detail kegiatan select
                const detailKegiatanCol = document.createElement('div');
                detailKegiatanCol.className = 'col-md-6';
                const detailKegiatanLabel = document.createElement('label');
                detailKegiatanLabel.textContent = 'Detail Kegiatan';
                const detailKegiatanSelect = document.createElement('select');
                detailKegiatanSelect.className = 'form-control';
                detailKegiatanSelect.name = 'detail_kegiatan[]'; // Use array notation for multiple inputs
                detailKegiatanSelect.id = 'detailKegiatanSelect'; // Add ID to detail kegiatan select
                detailKegiatanCol.appendChild(detailKegiatanLabel);
                detailKegiatanCol.appendChild(detailKegiatanSelect);

                // Append nama kegiatan and detail kegiatan selects to the new row
                newRow.appendChild(namaKegiatanCol);
                newRow.appendChild(detailKegiatanCol);

                // Append the new row to the form container
                formContainer.appendChild(newRow);

                // Populate nama kegiatan select with options
                populateNamaKegiatanSelect();
            });
        });
    </script>
@endpush
