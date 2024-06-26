@extends('kader.layout')

@section('title', 'Tambah Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Tambah Data Keluarga')
@section('container')
    <div class="container">
        <ul class="nav nav-tabs" id="dataKeluargaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dasawisma-tab" data-toggle="tab" href="#dasawisma" role="tab"
                    aria-controls="dasawisma" aria-selected="true">Data Dasawisma</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab"
                    aria-controls="keluarga" aria-selected="false">Data Keluarga</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="kondisi-keluarga-tab" data-toggle="tab" href="#kondisi-keluarga" role="tab" aria-controls="kondisi-keluarga" aria-selected="false">Data Kondisi Keluarga</a>
            </li>
        </ul>
        <form action="{{ route('data_keluarga.store') }}" method="POST">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dasawisma" role="tabpanel" aria-labelledby="dasawisma-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-end mb-4">
                                <div class="col-md-2 d-flex justify-content-end">
                                    <!-- Tombol yang memicu modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modalSaya">
                                        Klik Info
                                    </button>
                                </div>
                            </div>

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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Dasawisma</label>
                                                {{-- <input type="text" class="form-control @error('dasa_wisma') is-invalid @enderror" name="dasa_wisma" id="dasa_wisma" placeholder="Masukkan Nama Dasa Wisma" value="{{ old('dasa_wisma') }}"> --}}
                                                <select class="form-control" id="id_dasawisma" name="id_dasawisma">
                                                    {{-- <option value="" hidden> Pilih Dasa Wisma</option> --}}
                                                    @foreach ($dasawisma as $c)
                                                        @if ($kader->id_dasawisma == $c->id)
                                                            <option selected value="{{ $c->id }}">
                                                                {{ $c->nama_dasawisma }}</option>
                                                        @endif
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
                                                <label>RW</label>
                                                <input type="hidden" disabled class="form-control" name="rw_id" id="rw_id"  value="{{ $kader->dasawisma->rw_id }}">
                                                <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rw->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>RT</label>
                                                <input type="hidden" disabled class="form-control" name="rt_id" id="rt_id"  value="{{ $kader->dasawisma->rt_id }}">
                                                <input type="number" disabled class="form-control"  value="{{ $kader->dasawisma->rt->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group @error('rw') is-invalid @enderror">
                                                <label for="exampleFormControlSelect1">Dusun</label>
                                                <input type="text"
                                                    class="form-control @error('dusun') is-invalid @enderror" name="dusun"
                                                    id="dusun" placeholder="Masukkan Nama Dusun"
                                                    value="{{ old('dusun') }}">
                                            </div>
                                            @error('dusun')
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
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Kabupaten</label>
                                                {{-- nama kabupaten --}}
                                                <input type="text" readonly
                                                    class="form-control @error('kabupaten') is-invalid @enderror"
                                                    name="kabupaten" id="kabupaten" placeholder="Masukkan kabupaten"
                                                    value="Indramayu">
                                                @error('kabupaten')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Provinsi</label>
                                                    <input type="text" readonly class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" placeholder="Masukkan Provinsi" value="Jawa Barat">
                                                    @error('provinsi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
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
                                    <!-- Tombol yang memicu modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modalSaya">
                                        Klik Info
                                    </button>
                                </div>
                            </div>

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row" id="container">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                {{-- <input type="text" class="form-control @error('nama_kepala_rumah_tangga') is-invalid @enderror" name="nama_kepala_rumah_tangga" id="nama_kepala_rumah_tangga" placeholder="Masukkan Nama Kepala Rumah Tangga" value="{{ old('nama_kepala_rumah_tangga') }}"> --}}
                                                <select name="warga[]" id="js-example-basic-multiple"
                                                    class="form-control js-example-basic-single" name="user_id[]">
                                                    <option selected disabled>Type to search</option>
                                                    @foreach ($warga as $warga)
                                                        <option value="{{ $warga->id }}">{{ $warga->nama }} - {{$warga->no_ktp}}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama_kepala_keluarga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Status</label>
                                                <select class="form-control" id="status" name="status[]">
                                                    {{-- <option selected> -- pili status --</option> --}}
                                                    <option selected value="kepala-keluarga">Kepala Keluarga</option>
                                                    {{-- <option value="ibu">Ibu</option>
                                                    <option value="anak">Anak</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="addRow" type="button" class="btn btn-primary">ADD</button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" data-action="next" class="btn btn-primary">Next</button>
                            {{-- <button type="submit" class="ml-2 btn btn-success">submit</button> --}}

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kondisi-keluarga" role="tabpanel" aria-labelledby="kondisi-keluarga-tab">
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
                                                        <input type="radio" name="punya_jamban" value=1 id="punya_jamban_ya"> Ya
                                                </div>
                                                <div class="col-md-2">
                                                        <input type="radio" name="punya_jamban" value=1 id="punya_jamban_tidak"> Tidak
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
                </div>
            </div>
        </form>
    </div>



    <!-- Contoh Modal -->
    <div class="modal fade" id="modalSaya" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel"
        aria-hidden="true">
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
                            <td>Dasa Wisma</td>
                            <td>Di isi sesuai dengan nama dasawisma yang diikuti warga yang bersangkutan</td>

                        </tr>
                        <tr>
                            <td>Nama Kepala Keluarga</td>
                            <td>Di isi dengan nama Kepala Rumah Tangga pada rumah yang didata.
                                Kepala Rumah Tangga adalah yang bertanggung jawab atas segala sesuatu yang terkait dengan
                                kegiatan di dalam rumah yang sedang didata.</td>

                        </tr>
                        <tr>
                            <td>Jumlah Balita</td>
                            <td>Diisi dengan jumlah Balita yang ada pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah PUS (Pasangan Usia Subur)</td>
                            <td>Diisi dengan jumlah Pasangan Usia Subur yang ada pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah WUS (Wanita Usia Subur)</td>
                            <td>Diisi dengan jumlah Wanita Usia Subur yakni Usia antara 14 tahun hingga 50 tahun pada rumah
                                yang sedang didata kecuali ada keterangan khusus. Misalnya terjadi manopouse dini karena
                                penyakit tertentu, dll.</td>
                        </tr>
                        <tr>
                            <td>Jumlah 3 Buta</td>
                            <td>Diisi dengan jumlah anggota rumah yang sedang didata
                                yang mengalami ‘3 Buta’ pada usia diatas 13 tahun (Buta Baca, Buta Tulis, Buta Hitung)</td>
                        </tr>
                        <tr>
                            <td>Jumlah Ibu Hamil</td>
                            <td>Diisi dengan jumlah ibu hamil pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Ibu Menyusui</td>
                            <td>Diisi dengan jumlah ibu yang sedang menyusui bayi pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Lansia</td>
                            <td>Diisi dengan jumlah orang tua lanjut usia pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Jumlah Kebutuhan Khusus</td>
                            <td>Diisi dengan jumlah anggota keluarga berkebutuhan khusus pada rumah yang sedang didata</td>
                        </tr>
                        <tr>
                            <td>Stiker P4K (Program Perencanaan Persalinan dan Pencegahan Komplikasi)</td>
                            <td>Stiker P4K berisi data tentang : nama ibu hamil, taksiran persalinan, penolong persalinan,
                                tempat persalinan, pendamping persalinan, transport yang digunakan dan calon donor darah.
                            </td>
                        </tr>
                        <tr>
                            <td>Aktivitas UP2K ( Upaya Peningkatan Pendapatan Keluarga )</td>
                            <td>UP2K ( Upaya Peningkatan Pendapatan Keluarga ) adalah merupakan salah satu program
                                penanggulangan kemiskinan khususnya bagi kaum perempuan.</td>
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

            $("#datepicker").datepicker({

                changeMonth: true,

                changeYear: true

            });

        });

        window.onload = function() {

            $('#tgl_lahir').on('change', function() {

                var dob = new Date(this.value);

                var today = new Date();

                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));

                $('#umur').val(age);

            });

        }
    </script>

    <script>
        $(document).ready(function() {
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
                                    '<option value="" hidden>Pilih Desa</option>');
                                $.each(data, function(key, desas) {
                                    $('select[name="id_desa"]').append(
                                        '<option value="' + key + '">' + desas
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

    // Fungsi untuk menambahkan row saat tombol diklik
    document.getElementById('addRow').addEventListener('click', function() {
        var container = document.getElementById('container');
        var rownew = document.createElement('div');
        rownew.className = 'row w-100';
        rownew.innerHTML = `
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <select id="warga${warga}" class="form-control js-example-basic-single" name="warga[]">
                                <option selected disabled value="AL">Type to search</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status[]">
                                <option disabled selected> -- pilih status -- </option>

                                <option value="ibu">Ibu</option>
                                <option value="anak">Anak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(rownew);

        var selectElement = document.getElementById(`warga${warga}`);
        // Loop melalui data yang telah disimpan sebelumnya dan tambahkan opsi ke select
        if (data) {
            data.forEach(function(item) {
                var option = document.createElement('option');
                option.value = item.id;
                option.text(`${item.nama} - ${item.no_ktp}`)
                selectElement.appendChild(option);
            });
        }
        warga++; // Tambahkan 1 ke nilai warga setiap kali tombol ditekan
    });
</script>


@endpush
