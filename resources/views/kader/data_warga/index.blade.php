@extends('kader.layout')

@section('title', 'Data Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Warga')
@section('container')
    <!-- Main content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row w-full ">
                    <div class="col-12 col-md-12 col-lg-12 ">
                        <div class="card">
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                                <div class="table-responsive" style="overflow: hidden">
                                    <table class="table table-striped table-bordered data" id="add-row" width="84vw">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-md-1">
                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                    <a href="{{ url('data_warga/create') }}" type="button"
                                                        class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false" style="background-color: #6e9ebb; color:white">
                                                            Pilihan
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($dataPeriode as $item)
                                                                <a class="dropdown-item"
                                                                    href="{{ url('data_warga?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">No</th>
                                                <th style="vertical-align: middle;">Nama</th>
                                                <th style="vertical-align: middle;">Nama Kepala Keluarga</th>
                                                <th style="vertical-align: middle;">No. Registrasi</th>
                                                <th style="vertical-align: middle;">No. KTP/NIK</th>
                                                <th style="vertical-align: middle;">Jabatan</th>
                                                <th style="vertical-align: middle;">Jenis Kelamin</th>
                                                <th style="vertical-align: middle;">Periode</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warga as $c)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ ucfirst($c->nama) }} <br>
                                                        @if (!$c->is_valid)
                                                            <a href="{{ url('data_warga/' . $c->id . '/edit') }}" class="btn btn-sm" style="background-color: #50A3B9; color:white">
                                                                Edit untuk validasi
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($c->kepalaKeluarga->isNotEmpty())
                                                            @foreach ($c->kepalaKeluarga as $keluarga)
                                                                {{ $keluarga->keluarga->nama_kepala_keluarga }}<br>
                                                            @endforeach
                                                        @else
                                                            Belum ada kepala keluarga terkait<br>
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->no_registrasi) }}
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->no_ktp) }}</td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->jabatan) }}</td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->jenis_kelamin) }}
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->periode) }}</td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#details-modal-{{ $c->id }}">
                                                                    <i class="far fa-eye text-white"></i>
                                                                </button>
                                                                <a class="btn btn-primary btn-sm ml-1"
                                                                    href="{{ url('data_warga/' . $c->id . '/edit') }}"><i class="fas fa-edit"></i>
                                                                </a>
                                                                @endif
                                                                <form action="{{ route('data_warga.destroy', $c->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete ml-1"><i class="fas fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @foreach ($warga as $c)
                                        <div id="details-modal-{{ $c->id }}" class="modal fade" tabindex="1"
                                            role="dialog" aria-labelledby="details-modal-{{ $c->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Details</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>
                                                            Dasawisma : <strong>
                                                                {{ ucfirst($c->dasawisma->nama_dasawisma) }}
                                                            </strong><br>
                                                            Nama Kepala Keluarga : <strong>
                                                                @if ($c->kepalaKeluarga->isNotEmpty())
                                                                    @foreach ($c->kepalaKeluarga as $keluarga)
                                                                        <strong>{{ $keluarga->keluarga->nama_kepala_keluarga }}</strong><br>
                                                                    @endforeach
                                                                @else
                                                                    <strong>Belum ada kepala keluarga terkait</strong><br>
                                                                @endif
                                                                No. Registrasi : <strong> {{ ucfirst($c->no_registrasi) }}
                                                                </strong><br>
                                                                No. KTP/NIK :
                                                                <strong>{{ ucfirst($c->no_ktp) }}</strong><br>
                                                                Nama : <strong> {{ ucfirst($c->nama) }} </strong><br>
                                                                Jabatan : <strong>{{ ucfirst($c->jabatan) }}</strong><br>
                                                                Jenis Kelamin : <strong> {{ ucfirst($c->jenis_kelamin) }}
                                                                </strong><br>
                                                                Tempat Lahir : <strong> {{ ucfirst($c->tempat_lahir) }}
                                                                </strong><br>
                                                                Tanggal Lahir:
                                                                <strong>{{ \Carbon\Carbon::parse($c->tgl_lahir)->isoFormat('D MMMM Y') }}/
                                                                    @if ($c->tgl_lahir)
                                                                        <?php
                                                                        // Menghitung umur berdasarkan tanggal lahir
                                                                        $tanggal_lahir = \Carbon\Carbon::parse($c->tgl_lahir);
                                                                        $umur = $tanggal_lahir->age;
                                                                        ?>
                                                                        <strong>{{ $umur }} Tahun</strong><br>
                                                                    @else
                                                                        <strong>Tidak Tersedia</strong><br>
                                                                    @endif

                                                                    Status Perkawinan : <strong>
                                                                        {{ ucfirst($c->status_perkawinan) }}</strong><br>
                                                                    Status Dalam Keluarga :
                                                                    @if ($c->kepalaKeluarga->isNotEmpty())
                                                                        @foreach ($c->kepalaKeluarga as $keluarga)
                                                                            <strong>{{ $keluarga->status }}</strong><br>
                                                                        @endforeach
                                                                    @else
                                                                        <strong>Belum ada kepala keluarga
                                                                            terkait</strong><br>
                                                                    @endif
                                                                    Agama : <strong> {{ ucfirst($c->agama) }} </strong><br>
                                                                    Alamat : <strong> {{ ucfirst($c->alamat) }}
                                                                    </strong><br>
                                                                    Pendidikan : <strong> {{ ucfirst($c->pendidikan) }}
                                                                    </strong><br>
                                                                    Pekerjaan : <strong> {{ ucfirst($c->pekerjaan) }}
                                                                    </strong><br>
                                                                    Akseptor KB : <strong> {{ ucfirst($c->akseptor_kb) }}
                                                                    </strong><br>
                                                                    Aktif dalam Kegiatan Posyandu : <strong>
                                                                        {{ ucfirst($c->aktif_posyandu) }} </strong><br>
                                                                    Mengikuti Program Bina Keluarga Balita : <strong>
                                                                        {{ ucfirst($c->ikut_bkb) }} </strong><br>
                                                                    Memiliki Tabungan : <strong>
                                                                        {{ ucfirst($c->memiliki_tabungan) }} </strong><br>
                                                                    Mengikuti Kelompok Belajar Jenis : <strong>
                                                                        {{ ucfirst($c->ikut_kelompok_belajar) }}
                                                                    </strong><br>
                                                                    Mengikuti PAUD/Sejenis : <strong>
                                                                        {{ ucfirst($c->ikut_paud_sejenis) }} </strong><br>
                                                                    Ikut dalam Kegiatan Koperasi : <strong>
                                                                        {{ ucfirst($c->ikut_koperasi) }} </strong><br>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Oke</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- /.content -->


    <!-- page script -->
@endsection

@push('script-addon')
    <script>
        $(document).ready(function() {
            $('.data').DataTable({
                scrollX:true,
                "order": []
            });
        });
    </script>
    <script>
        $('.delete').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Apakah anda yakin ingin menghapus data ini ?`,
                    text: "Jika anda menghapusnya maka datanya akan di hapus secara permanen",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endpush
