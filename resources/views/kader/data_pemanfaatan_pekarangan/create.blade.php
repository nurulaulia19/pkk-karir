@extends('kader.layout')

@section('title', 'Tambah Data Pemanfaatan Tanah Pekarangan | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Pemanfaatan Tanah Pekarangan')
@section('container')

<div class="col-md-8">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Data Pemanfaatan Tanah Pekarangan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('data_pemanfaatan.store') }}" method="POST">
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
                        <input type="hidden" class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{$c->id}}">
                        <input type="text" disabled class="form-control" name="id_desa" id="id_desa" placeholder="Masukkan Nama Desa" required value="{{ $c->nama_desa }}">
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
                        <input type="hidden" class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Kecamatan" required value="{{$c->id}}">
                        <input type="text" disabled class="form-control" name="id_kecamatan" id="id_kecamatan" placeholder="Masukkan Nama Kecamatan" required value="{{ $c->nama_kecamatan }}">
                        @endforeach
                    </div>
                    @error('id_kecamatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="col-md-2">
                    <div class="form-group @error('id_user') is-invalid @enderror">
                        @foreach ($kad as $c)
                            <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="Masukkan Nama Desa" value="{{$c->id}}">
                        @endforeach
                    </div>
                    @error('id_user')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group @error('rumah_tangga_id') is-invalid @enderror">
                        <label for="exampleFormControlSelect1">Nama Kepala Rumah Tangga</label>
                        <select class="form-control select-state @error('rumah_tangga_id') is-invalid @enderror" id="rumah_tangga_id" name="rumah_tangga_id" placeholder="Type to search.." required>
                          <option value=""> Pilih Kepala Rumah Tangga</option>
                            @foreach ($krt as $rumahTangga)
                                <option value="{{ $rumahTangga->id }}">{{ $rumahTangga->nama_kepala_rumah_tangga }} - {{$rumahTangga->nik_kepala_rumah_tangga}}</option>
                            @endforeach
                          </select>
                      </div>
                      @error('rumah_tangga_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
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
            {{-- tingting --}}
            <div class="form-group" id="formContainer">
                <div class="row">
                    <div class="col-md-12" class="@error('kategori_id') is-invalid @enderror">
                        <label for="kategori_id">Nama Pemanfaatan</label>
                        <select class="form-control selectNamaKegiatan @error('kategori_id') is-invalid @enderror" name="kategori_id[]" required>
                            <option disabled selected value="">Pilih Pemanfaatan Tanah Pekarangan</option>
                            @foreach ($kategoriPemanfaatan as $item)
                                <option
                                    value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-center mt-4">
                        {{-- <a href="{{ route('data-kegiatan-warga-delete', ['id' => $wargaKeg->id]) }}"
                            class="btn btn-danger btn-sm mt-2">Delete</a> --}}
                    </div>
                </div>
        </div>

        <div class="row d-flex justify-content-end mr-1">
            <button type="button" id="addButton" class="btn" style="background-color: #50A3B9; color:white"><i class="fas fa-plus"></i></button>
        </div>
        {{-- end tingting --}}
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/data_pemanfaatan" class="btn btn-outline-danger">
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


<script>
    $(document).ready(function() {
        console.log(kategoriPemanfaatanLahan )
        let data; // Variabel untuk menyimpan data kegiatan

        console.log('data :>> ', data);
        var kategoriPemanfaatanLahan = @json($kategoriPemanfaatan);
        data = kategoriPemanfaatanLahan;
console.log('kategoriPemanfaatanLahan :>> ', kategoriPemanfaatanLahan);

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
                namaKegiatanLabel.textContent = 'Nama Pemanfaatan';
                namaKegiatanLabel.htmlFor = 'kategori_id'; // Set 'for' attribute for label

                const namaKegiatanSelect = document.createElement('select');
                namaKegiatanSelect.className = 'form-control selectNamaKegiatan';
                namaKegiatanSelect.name = 'kategori_id[]';

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
                defaultOptionNamaKegiatan.textContent = 'Pilih Nama Pemanfaatan ';
                defaultOptionNamaKegiatan.selected = true;
                defaultOptionNamaKegiatan.disabled = true;
                newSelect.appendChild(defaultOptionNamaKegiatan);

                // Add options based on data
                if (data) {
                    data.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nama_kategori;
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
