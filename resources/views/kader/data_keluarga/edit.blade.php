@extends('kader.layout')

@section('title', 'Edit Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Edit Data Keluarga')
@section('container')

<div class="container">
    <ul class="nav nav-tabs" id="dataKeluargaTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="dasawisma-tab" data-toggle="tab" href="#dasawisma" role="tab" aria-controls="dasawisma" aria-selected="true">Data Dasawisma</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false">Data Keluarga</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" id="kondisi-keluarga-tab" data-toggle="tab" href="#kondisi-keluarga" role="tab" aria-controls="kondisi-keluarga" aria-selected="false">Data Kondisi Keluarga</a>
        </li> --}}
    </ul>

    <form action="{{ url('data_keluarga', $data_keluarga->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dasawisma" role="tabpanel" aria-labelledby="dasawisma-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end mb-4">
                            <div class="col-md-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSaya">
                                    Klik Info
                                </button>
                            </div>
                        </div>

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
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Dasa Wisma</label>
                                            <select class="form-control" id="id_dasawisma" name="id_dasawisma">
                                                @foreach ($dasawisma as $c)
                                                    <option value="{{$c->id}}" {{ $c->id === $c->id_dasawisma ? 'selected' : '' }}>{{ $c->nama_dasawisma }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('dasa_wisma')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">RW</label>
                                            <input type="hidden" disabled class="form-control" name="rw_id" id="rw_id"  value="{{ $kader->dasawisma->rw_id }}">
                                            <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rw->name }}">
                                        </div>
                                        @error('rw_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">RT</label>
                                            <input type="hidden" disabled class="form-control" name="rt_id" id="rt_id"  value="{{ $kader->dasawisma->rt_id }}">
                                            <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rt->name }}">
                                        </div>
                                        @error('rt')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group @error('rw') is-invalid @enderror">
                                            <label for="exampleFormControlSelect1">Dusun</label>
                                            <input type="text" class="form-control @error('dusun') is-invalid @enderror" name="dusun" id="dusun" placeholder="Masukkan Nama Dusun" value="{{ old('dusun', $data_keluarga->dusun) }}">
                                        </div>
                                        @error('dusun')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
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
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Kabupaten</label>
                                            {{-- nama kabupaten --}}
                                            <input type="text" readonly class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten" placeholder="Masukkan Kabupaten" value="{{ $kabupaten->name }}">
                                                @error('kabupaten')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                               <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Provinsi</label>
                                            {{-- nama provinsi --}}
                                            <input type="text" readonly class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" placeholder="Masukkan Provinsi" value="{{ $provinsi->name }}">
                                            @error('provinsi')
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
                                                <option value="{{ $data_keluarga->periode }}" selected>{{ $data_keluarga->periode }}</option>
                                            </select>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" data-action="next" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end mb-4">
                            <div class="col-md-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSaya">
                                    Klik Info
                                </button>
                            </div>
                        </div>

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
                        <div class="row" id="container">
                            @foreach ($data_keluarga->anggota as $index => $item)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group @error('warga') is-invalid @enderror">
                                                <label>Nama</label>
                                                <select name="warga[]" class="form-control js-example-basic-single select-state @error('warga') is-invalid @enderror" placeholder="Type to search..." required>
                                                    <option value="">Pilih Nama Warga</option>
                                                    @foreach ($data_keluarga->anggota as $warga)
                                                        <option value="{{ $warga->warga->id }}" {{ $item->warga->id == $warga->warga->id ? 'selected' : '' }}>{{ $warga->warga->nama }} - {{ $warga->warga->no_ktp }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama_kepala_keluarga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status[]">
                                                    @if ($index == 0)
                                                        <option value="kepala-keluarga" selected>Kepala Keluarga</option>
                                                    @else
                                                        {{-- <option value="kepala-keluarga">Kepala Keluarga</option> --}}
                                                        <option value="ibu" {{ $item->status == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                                        <option value="anak" {{ $item->status == 'anak' ? 'selected' : '' }}>Anak</option>
                                                        <option value="lainnya" {{ $item->status == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1 d-flex align-items-center">
                                            <a href="{{route('keluarga-delete-warga',['id' =>$item->id ])}}" class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end">
                            <button id="addRow" type="button" class="btn" style="background-color: #50A3B9; color:white"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn" style="background-color: #50A3B9; color:white">
                            @if ($data_keluarga->is_valid)
                                Edit
                            @else
                                Validasi
                            @endif
                        </button>
                        <a href="/data_keluarga" class="btn btn-outline-danger">
                            <span>Batalkan</span>
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="kondisi-keluarga" role="tabpanel" aria-labelledby="kondisi-keluarga-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end mb-4">
                            <div class="col-md-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSaya">
                                    Klik Info
                                </button>
                            </div>
                        </div>

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
                                    <div class="form-group @error('punya_jamban') is-invalid @enderror">
                                        <div >
                                            <label>Punya Jamban ?</label>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input  {{ $data_keluarga->punya_jamban === 1 ? 'checked' : '' }} type="radio" name="punya_jamban" value="1" id="punya_jamban_ya"> Ya
                                            </div>
                                            <div class="col-md-2">
                                                    <input {{ $data_keluarga->punya_jamban === 0 ? 'checked' : '' }} type="radio" name="punya_jamban" value="0" id="punya_jamban_tidak"> Tidak
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    @error('punya_jamban')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="/data_keluarga" class="btn btn-outline-primary">
                            <span>Batalkan</span>
                        </a>
                    </div>
                </div>
            </div> --}}

        </div>
    </form>
</div>
<!-- Contoh Modal -->
<div class="modal fade" id="modalSaya" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSayaLabel">Info Keterangan Atribut </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <th colspan="1">Point/Isian</th>
                        <th>Penjelasan</th>
                    </tr>
                    <tr>
                        <td>Nama Pertama</td>
                        <td>Di isi dengan nama kepala dalam satu keluarga pada rumah yang didata.
                            Kepala Keluarga adalah yang bertanggung jawab atas segala sesuatu yang terkait dengan
                            keluarga di dalam rumah yang sedang didata.
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Kedua dan Seterusnya</td>
                        <td>Di isi dengan nama Anggota Keluarga pada rumah yang didata.</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>Di isi dengan status dari masing-masing Anggota Keluarga pada rumah yang didata.</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-addon')

<script type="text/javascript">

    $(function() {

      $( "#datepicker" ).datepicker({

             changeMonth: true,

             changeYear: true

         });

    });

       window.onload=function(){

           $('#tgl_lahir').on('change', function() {

               var dob = new Date(this.value);

               var today = new Date();

                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

               $('#umur').val(age);

           });

       }

</script>
{{-- <script>
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

    $(document).on('click', '[data-action="next"]', function(e) {
                var $active = $('#dataKeluargaTabs .active');
                var hasError = false;

                $($active.attr('href')).find('[name]').each(function() {
                    if ((!$(this).prop('disabled') || !$(this).prop('readonly')) && !$(this)
                        .val()) {
                        $(this).addClass('is-invalid');
                        hasError = true;
                    }
                });
                if (!hasError) {
                    $active.parent().next().find('a').click();
                }
            });
</script> --}}

<script>
    $(document).on('click', '[data-action="next"]', function (e) {
        var $active = $('#dataKeluargaTabs .nav-link.active');
        var hasError = false;

        $($active.attr('href')).find('input[required]').each(function () {
            // Periksa input yang tidak disabled atau readonly
            if (!$(this).prop('disabled') && !$(this).prop('readonly') && !$(this).val()) {
                $(this).addClass('is-invalid');
                hasError = true;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!hasError) {
            // Temukan tab berikutnya dan aktifkan
            var $nextTab = $active.parent().next().find('a');
            if ($nextTab.length > 0) {
                $nextTab.tab('show');
            }
        }
    });
</script>


<script>
    let data; // Variabel untuk menyimpan data warga
    let warga = 1; // Variabel untuk menyimpan nomor select

    // Fungsi untuk melakukan permintaan API sekali saja di awal
    $(document).ready(function() {
        $.ajax({
            url: "/warga",
            type: "GET",
            success: function(response) {
                console.log(response);
                data = response.warga; // Simpan data warga dalam variabel
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });



    // $('#addRow').on('click', function() {
    //     var container = $('#container');
    //     var rownew = $('<div class="row w-100"></div>');
    //     rownew.html(`
    //         <div class="col-md-12">
    //             <div class="row">
    //                 <div class="col-md-6">
    //                     <div class="form-group">
    //                         <label>Nama</label>
    //                         <select id="warga${warga}" class="form-control js-example-basic-single" name="warga[]">
    //                             <option selected disabled value="AL">Type to search</option>
    //                         </select>
    //                     </div>
    //                 </div>
    //                 <div class="col-md-5">
    //                     <div class="form-group">
    //                         <label>Status</label>
    //                         <select class="form-control status-select" name="status[]">
    //                         </select>
    //                     </div>
    //                 </div>
    //                 <div class="col-md-1 d-flex align-items-center">
    //                     <button onclick='onDelete(${warga})' class="btn btn-danger btn-sm mt-2">Delete</button>
    //                 </div>
    //             </div>
    //         </div>
    //     `);
    //     container.append(rownew);

    //     var selectElement = $(`#warga${warga}`);
    //     // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
    //     console.log('aul',data)
    //     if (data) {
    //         data.forEach(function(item) {
    //             var option = $('<option></option>');
    //             option.val(item.id);
    //             option.text(`${item.nama} - ${item.no_ktp}`)
    //             selectElement.append(option);
    //         });
    //     }

    //     // Mengecek apakah ini adalah baris pertama atau bukan
    //     if ($('#container .status-select').length === 0) {
    //         // Jika ini adalah baris pertama, tambahkan opsi "kepala keluarga"
    //         rownew.find('.status-select').append('<option value="kepala-keluarga">Kepala Keluarga</option>');
    //     } else {
    //         // Jika ini bukan baris pertama, tambahkan opsi "ibu", "anak", dan "lainnya"
    //         var statusSelect = rownew.find('.status-select');
    //         statusSelect.append('<option value="ibu">Ibu</option>');
    //         statusSelect.append('<option value="anak">Anak</option>');
    //         statusSelect.append('<option value="lainnya">Lainnya</option>');
    //     }

    //     warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    // });

    $('#addRow').on('click', function() {
        var container = $('#container');
        var rownew = $('<div class="row w-100"></div>');
        rownew.html(`
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @error('warga') is-invalid @enderror">
                            <label>Nama</label>
                            <select id="warga${warga}" placeholder="Type to search..." class="form-control js-example-basic-single @error('warga') is-invalid @enderror" name="warga[]" required>
                                <option value="">Type to search</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control status-select" name="status[]">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button onclick='onDelete(${warga})' class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `);
        container.append(rownew);

        var selectElement = $(`#warga${warga}`);
        // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
        console.log('aul',data)
        if (data) {
            data.forEach(function(item) {
                var option = $('<option></option>');
                option.val(item.id);
                option.text(`${item.nama} - ${item.no_ktp}`)
                selectElement.append(option);
            });
        }

        // Mengecek apakah ini adalah baris pertama atau bukan
        if ($('#container .status-select').length === 0) {
            // Jika ini adalah baris pertama, tambahkan opsi "kepala keluarga"
            rownew.find('.status-select').append('<option value="kepala-keluarga">Kepala Keluarga</option>');
        } else {
            // Jika ini bukan baris pertama, tambahkan opsi "ibu", "anak", dan "lainnya"
            var statusSelect = rownew.find('.status-select');
            statusSelect.append('<option value="ibu">Ibu</option>');
            statusSelect.append('<option value="anak">Anak</option>');
            statusSelect.append('<option value="lainnya">Lainnya</option>');
        }

        // Menambahkan fungsi selectize ke elemen <select> baru
        selectElement.selectize();

        warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    });

    function onDelete(id){
        $(`#warga${id}`).closest('.row').remove();
    }
</script>

<script>
    // Mencetak data yang dikirim dari controller ke konsol
    console.log(@json($data_keluarga));
</script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

{{-- <script>
    $(document).ready(function() {
        $('#select-state').selectize();
    });
</script> --}}
<script>
    $(document).ready(function() {
        $('.select-state').selectize();
    });
</script>
@endpush
