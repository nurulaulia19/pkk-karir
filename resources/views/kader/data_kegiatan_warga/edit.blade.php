@extends('kader.layout')

@section('title', 'Edit Data Kegiatan Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Edit Data Kegiatan Warga')
@section('container')

    <div class="col-md-10">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Data Kegiatan Warga</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form action="{{ route('data_kegiatan.updated', ['id' => 1]) }}" method="POST">
                @csrf
                @method('PUT')

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
                    </div>
                    {{-- cekuek  --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nama Warga</label>
                                <select class="form-control @error('id_warga') is-invalid @enderror" id="id_warga"
                                    name="id_warga">
                                    <option selected value="{{ $warga->id }}"> {{ $warga->id }}-{{ $warga->nama }}
                                    </option>
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
                                <label>Periode</label>
                                <select class="form-control" id="periode" name="periode" readonly>
                                    {{-- Tampilkan opsi select dengan nilai default dari properti periode --}}
                                    <option value="{{ $warga->periode }}" selected>{{ $warga->periode }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- tingting --}}
                    <div class="form-group" id="formContainer">
                        {{-- @dd($warga->kegiatan) --}}
                        @foreach ($warga->kegiatan as $wargaKeg)
                            <div class="row">
                                <div class="col-md-11">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <select class="form-control selectNamaKegiatan" name="nama_kegiatan[]">
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach ($keg as $item)
                                            <option {{ $wargaKeg->data_kegiatan_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex align-items-center mt-4">
                                    <a href="{{ route('data-kegiatan-warga-delete', ['id' => $wargaKeg->id]) }}"
                                        class="btn btn-danger btn-sm mt-2">Delete</a>
                                </div>
                            </div>
                        @endforeach
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
                    deleteButton.textContent = 'Delete';
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
@endpush
