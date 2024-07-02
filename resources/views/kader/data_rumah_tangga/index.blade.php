@extends('kader.layout')

@section('title', 'Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Keluarga')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" style="overflow: hidden">
                                    <table class="table table-striped table-bordered data" id="add-row" width="83vw">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-md-1">
                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                    <a href="{{ url('data_rumah_tangga/create') }}" type="button"
                                                        class="btn"
                                                        style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"
                                                            style="background-color: #6e9ebb; color:white">
                                                            Pilihan
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($dataPeriode as $item)
                                                                <a class="dropdown-item"
                                                                    href="{{ url('data_rumah_tangga?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">No</th>
                                                <th style="vertical-align: middle;">Nama Kepala Rumah Tangga</th>
                                                <th style="vertical-align: middle;">Dasawisma</th>
                                                <th style="vertical-align: middle;">RT</th>
                                                <th style="vertical-align: middle;">RW</th>
                                                <th style="vertical-align: middle;">Tahun</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($krt as $c)
                                                <tr>
                                                    <td style="vertical-align: middle; position: relative;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->nama_kepala_rumah_tangga) }}
                                                        <br>
                                                        @if (!$c->is_valid)
                                                            <a href="{{ url('data_rumah_tangga/' . $c->id . '/edit') }}"
                                                                class="btn btn-sm"
                                                                style="background-color: #50A3B9; color:white">
                                                                Edit untuk validasi
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($c->dasawisma)
                                                            {{ ucfirst($c->dasawisma->nama_dasawisma) }}
                                                        @else
                                                            N/A
                                                            <!-- Tampilkan pesan alternatif jika dasawisma tidak tersedia -->
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($c->dasawisma)
                                                            {{ ucfirst($c->dasawisma->rw->name) }}
                                                        @else
                                                            N/A
                                                            <!-- Tampilkan pesan alternatif jika dasawisma tidak tersedia -->
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($c->dasawisma)
                                                            {{ ucfirst($c->dasawisma->rt->name) }}
                                                        @else
                                                            N/A
                                                            <!-- Tampilkan pesan alternatif jika dasawisma tidak tersedia -->
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ $c->periode }}</td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#details-modal-{{ $c->id }}">
                                                                    <i class="far fa-eye text-white"></i>
                                                                </button>
                                                                <a class="btn btn-primary btn-sm ml-1"
                                                                    href="{{ url('data_rumah_tangga/' . $c->id . '/edit') }}"><i
                                                                        class="fas fa-edit"></i>
                                                                </a>
                                                                @endif
                                                                <form
                                                                    action="{{ route('data_rumah_tangga.destroy', $c->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete ml-1"><i
                                                                            class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @foreach ($krt as $c)
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
                                                            Dasawisma :
                                                            <strong>
                                                                {{ ucfirst($c->dasawisma->nama_dasawisma) }}
                                                            </strong>
                                                            <br>
                                                            RT / RW :
                                                            <strong>
                                                                {{ $c->dasawisma->rt->name }} /
                                                                {{ $c->dasawisma->rw->name }}
                                                            </strong> <br>
                                                            Desa/Kel :
                                                            <strong>
                                                                {{ ucfirst($c->dasawisma->desa->nama_desa) }}
                                                            </strong>
                                                            <br>
                                                            Kec.
                                                            <strong>
                                                                {{ ucfirst($c->dasawisma->desa->kecamatan->nama_kecamatan) }}
                                                            </strong>,
                                                            Kabupaten
                                                            <strong>
                                                                {{ ucfirst($c->dasawisma->desa->kecamatan->kabupaten->name) }}
                                                            </strong>,
                                                            Provinsi
                                                            <strong>
                                                                {{ ucfirst($c->dasawisma->desa->kecamatan->kabupaten->provinsi->name) }}
                                                            </strong>
                                                            <br>
                                                            Nama Kepala Rumah Tangga :
                                                            <strong>
                                                                {{ $c->nama_kepala_rumah_tangga }}
                                                            </strong><br>
                                                            Jumlah KK :
                                                            <strong>
                                                                {{ ucfirst($c->anggotaRT->count()) }}
                                                            </strong>
                                                            <br>
                                                            @if ($c->punya_jamban)
                                                                Mempunyai Jamban Keluarga: <strong> Ya / 1 Buah</strong><br>
                                                            @else
                                                                Mempunyai Jamban Keluarga: <strong> Tidak/
                                                                    {{ $c->jumlah_jamban }} Buah</strong><br>
                                                            @endif
                                                            Sumber Air Keluarga:
                                                            @if ($c->sumber_air_pdam)
                                                                <strong> PDAM</strong>
                                                            @else

                                                            @endif
                                                            @if ($c->sumber_air_sumur)
                                                                <strong> Sumur</strong>
                                                            @else

                                                            @endif

                                                            @if ($c->sumber_air_lainnya)
                                                                <strong> Lainnya</strong> <br>
                                                            @else
                                                                <br>
                                                            @endif

                                                            @if ($c->punya_tempat_sampah)
                                                                Memiliki Tempat Pembuangan Sampah: <strong> Ya</strong><br>
                                                            @else
                                                                Memiliki Tempat Pembuangan Sampah: <strong>
                                                                    Tidak</strong><br>
                                                            @endif
                                                            @if ($c->saluran_pembuangan_air_limbah)
                                                                Mempunyai Saluran Pembuangan Air Limbah: <strong>
                                                                    Ya</strong><br>
                                                            @else
                                                                Mempunyai Saluran Pembuangan Air Limbah: <strong>
                                                                    Tidak</strong><br>
                                                            @endif
                                                            @if ($c->tempel_stiker)
                                                                Menempel Stiker P4K: <strong> Ya</strong><br>
                                                            @else
                                                                Menempel Stiker P4K: <strong> Tidak</strong><br>
                                                            @endif
                                                            @if ($c->kriteria_rumah_sehat)
                                                                Kriteria Rumah : <strong>Sehat</strong><br>
                                                            @else
                                                                Kriteria Rumah : <strong>Kurang Sehat</strong><br>
                                                            @endif
                                                            <br>
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
                scrollX: true,
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
