@extends('kader.layout')

@section('title', 'Tambah Data Kegiatan Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Kegiatan Warga')
@section('container')

    <div class="col-md-10">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header" style="background-color: #50A3B9; color:white">
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
                    </div>
                    {{-- cekuek  --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nama Warga</label>
                                <select class="form-control @error('id_warga') is-invalid @enderror select-state" id="id_warga"
                                    name="id_warga" placeholder="Type to search.." required>
                                    {{-- nama warga --}}
                                    <option value=""> Pilih Nama Warga</option>
                                    @foreach ($warga as $c)
                                        <option value="{{ $c->id }}">
                                            {{ $c->nama }} - {{ $c->no_ktp }}
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
                    <div class="form-group" id="formContainer">
                            <div class="row">
                                <div class="col-md-12 @error('nama_kegiatan') is-invalid @enderror">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <select class="form-control selectNamaKegiatan" name="nama_kegiatan[]" required>
                                        <option selected disabled value="">Pilih Kegiatan</option>
                                        @foreach ($keg as $item)
                                            <option
                                                value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_kegiatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-1 d-flex align-items-center mt-4">
                                    {{-- <a href="{{ route('data-kegiatan-warga-delete', ['id' => $wargaKeg->id]) }}"
                                        class="btn btn-danger btn-sm mt-2">Delete</a> --}}
                                </div>
                            </div>
                    </div>

                    <div class="row d-flex justify-content-end mr-1">
                        <button type="button" id="addButton" class="btn" style="background-color: #50A3B9; color:white"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                    {{-- end tingting --}}
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
                    <a href="/data_kegiatan" class="btn btn-outline-danger">
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
        let data; // Variabel untuk menyimpan data kegiatan

        // Fungsi untuk mengambil data kegiatan saat halaman dimuat
        $.ajax({
            url: "{{ route('kegiatanInDesa', ['id' => 1]) }}",
            type: "GET",
            success: function(response) {
                console.log('Data Kegiatan:', response);
                data = response.data; // Simpan data kegiatan ke dalam variabel
                populateNamaKegiatanSelect(); // Panggil fungsi untuk mengisi opsi nama kegiatan
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });

        // Event listener untuk tombol "Add"
        const addButton = document.querySelector('#addButton');
        const formContainer = document.querySelector('#formContainer');
        let totalClick = 1;

        addButton.addEventListener('click', function() {
            if (totalClick <= data.length) {
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 align-items-center'; // Add alignment classes

                const namaKegiatanCol = document.createElement('div');
                namaKegiatanCol.className = 'col-md-11'; // Adjusted column width for select

                const namaKegiatanLabel = document.createElement('label');
                namaKegiatanLabel.textContent = 'Nama Kegiatan';
                namaKegiatanLabel.htmlFor = 'nama_kegiatan'; // Set 'for' attribute for label

                const namaKegiatanSelect = document.createElement('select');
                namaKegiatanSelect.className = 'form-control selectNamaKegiatan';
                namaKegiatanSelect.name = 'nama_kegiatan[]';

                const deleteButtonDiv = document.createElement('div');
                deleteButtonDiv.className =
                'col-md-1 d-flex align-items-center mt-4'; // Adjusted column width for delete button

                const deleteButton = document.createElement('a');
                deleteButton.href = '#'; // Set href attribute for delete button
                deleteButton.className = 'btn btn-danger btn-sm mt-2';
                deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                deleteButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default link behavior
                    newRow.remove();
                    totalClick--; // Decrease totalClick when row is removed
                });

                // Append elements to their respective containers
                namaKegiatanCol.appendChild(namaKegiatanLabel);
                namaKegiatanCol.appendChild(namaKegiatanSelect);

                deleteButtonDiv.appendChild(deleteButton);

                newRow.appendChild(namaKegiatanCol);
                newRow.appendChild(deleteButtonDiv);

                formContainer.appendChild(newRow);

                // Populate select options
                const newSelect = newRow.querySelector('select');
                newSelect.innerHTML = '';

                const defaultOptionNamaKegiatan = document.createElement('option');
                defaultOptionNamaKegiatan.value = '';
                defaultOptionNamaKegiatan.textContent = 'Pilih Nama Kegiatan';
                defaultOptionNamaKegiatan.selected = true;
                defaultOptionNamaKegiatan.disabled = true;
                newSelect.appendChild(defaultOptionNamaKegiatan);

                // Add options based on data
                if (data) {
                    data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        newSelect.appendChild(option);
                    });
                }

                totalClick++; // Increment totalClick counter
            } else {
                alert('Semua data kegiatan sudah ditambahkan.');
            }
        });


    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script>
    $(document).ready(function() {
        $('.select-state').selectize();
    });
</script>
@endpush
