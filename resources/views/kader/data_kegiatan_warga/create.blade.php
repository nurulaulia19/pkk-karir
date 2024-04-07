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

                    {{-- tingting --}}
                    <div class="form-group" id="formContainer">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama_kegiatan">Nama Kegiatan</label>
                                <select class="form-control selectNamaKegiatan"  name="nama_kegiatan[]">
                                    <option value="">Pilih Kegiatan</option>
                                    @foreach ($keg as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-end mr-1">
                        <button type="button" id="addButton" class="btn btn-primary">Add</button>
                    </div>
                    {{-- end tingting --}}
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
            let data;
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

            // Fungsi untuk mengisi opsi "Nama Kegiatan" pada elemen select
            function populateNamaKegiatanSelect() {
                const namaKegiatanSelects = document.querySelectorAll('.selectNamaKegiatan');

                namaKegiatanSelects.forEach(function(select) {
                    // Kosongkan opsi yang ada sebelumnya pada setiap select
                    select.innerHTML = '';

                    const defaultOptionNamaKegiatan = document.createElement('option');
                    defaultOptionNamaKegiatan.value = '';
                    defaultOptionNamaKegiatan.textContent = 'Pilih Nama Kegiatan';
                    select.appendChild(defaultOptionNamaKegiatan);

                    // Tambahkan opsi nama kegiatan berdasarkan data yang tersedia
                    if (data) {
                        data.forEach(function(item) {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            select.appendChild(option);
                        });
                    }
                });
            }

            // Event listener untuk tombol "Add"
            const addButton = document.querySelector('#addButton');
            const formContainer = document.querySelector('#formContainer');
            let totalClick = 1;
            addButton.addEventListener('click', function() {
                totalClick++;
                if (totalClick <= data.length) {

                    const newRow = document.createElement('div');
                    newRow.className = 'row';

                    const namaKegiatanCol = document.createElement('div');
                    namaKegiatanCol.className = 'col-md-12';

                    const namaKegiatanLabel = document.createElement('label');
                    namaKegiatanLabel.textContent = 'Nama Kegiatan';

                    const namaKegiatanSelect = document.createElement('select');
                    namaKegiatanSelect.className =
                    'form-control selectNamaKegiatan'; // Gunakan kelas sebagai selector
                    namaKegiatanSelect.name = 'nama_kegiatan[]';
                    namaKegiatanCol.appendChild(namaKegiatanLabel);
                    namaKegiatanCol.appendChild(namaKegiatanSelect);
                    newRow.appendChild(namaKegiatanCol);
                    formContainer.appendChild(newRow);

                    populateNamaKegiatanSelect
                (); // Isi ulang opsi nama kegiatan setelah menambahkan select baru
                } else {
                    alert('Semua data kegiatan sudah ditambahkan.');
                }
            });
        });
    </script>
@endpush
