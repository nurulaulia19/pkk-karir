@extends('admin_desa.layout')

@section('title',
    'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Desa/Kelurahan | Admin Desa/Kelurahan PKK Kab.
    Indramayu')

@section('bread', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Desa/Kelurahan')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h6 class="d-flex justify-content-center"><strong>REKAPITULASI</strong></h6>
                                    <h6 class="d-flex justify-content-center"><strong>CATATAN DATA DAN KEGIATAN
                                            WARGA</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>KELOMPOK DESA/KELURAHAN</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>TAHUNx</strong> </h6>
                                </div>
                                <div>
                                    <h6>Desa/Kel :
                                        x
                                    </h6>
                                    <h6>Kecamatan :
                                        x
                                    </h6>
                                    <h6>Kabupaten :
                                        x
                                    </h6>
                                    <h6>Provinsi :
                                        x
                                    </h6>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;">No</th>
                                                <th rowspan="2" style="text-align: center;">Nama dusun</th>
                                                <th rowspan="2" style="text-align: center;">Jml RW</th>
                                                <th rowspan="2" style="text-align: center;">Jml RT</th>
                                                <th rowspan="2" style="text-align: center;">Jml Dasawisma</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KRT</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KK</th>
                                                <th colspan="12" style="text-align:center;">Jumlah Anggota Keluarga</th>
                                                <th colspan="5" style="text-align:center;">Kriteria Rumah</th>
                                                <th colspan="3" style="text-align:center;">Sumber Air Keluarga</th>
                                                <th colspan="2" style="text-align:center;">Makanan Pokok</th>
                                                <th colspan="4" style="text-align:center;">Warga Mengikuti Kegiatan</th>
                                                {{-- <th rowspan="2" style="text-align: center;">Ket</th> --}}
                                            </tr>
                                            <tr>
                                                <th>Total L</th>
                                                <th>Total P</th>
                                                <th>Balita L</th>
                                                <th>Balita P</th>
                                                <th>PUS</th>
                                                <th>WUS</th>
                                                <th>Ibu Hamil</th>
                                                <th>Ibu Menyusui</th>
                                                <th>Lansia</th>
                                                <th>3 Buta</th>
                                                <th>Berkebutuhan Khusus</th>
                                                <th>Sehat Layak Huni</th>
                                                <th>Tidak Sehat Layak Huni</th>
                                                <th>Memiliki Tmp. Pemb. Sampah</th>
                                                <th>Memiliki SPAL</th>
                                                <th>Memiliki Jamban Keluarga</th>
                                                <th>Menempel Stiker P4K</th>
                                                <th>PDAM</th>
                                                <th>Sumur</th>
                                                <th>DLL</th>
                                                <th>Beras</th>
                                                <th>Non Beras</th>
                                                <th>UP2K</th>
                                                <th>Pemanfaatan dan Pekarangan</th>
                                                <th>Industri Rumah Tangga</th>
                                                <th>Kesehatan Lingkungan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dusun as $dsn)
                                                @php
                                                    $counts = app(
                                                        'App\Http\Controllers\AdminDesa\DusunController',
                                                    )->countDataInDusun($dsn);
                                                @endphp

                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $dsn->name }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                     {{ $counts['countRw']}}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $counts['countRt']}}


                                                    </td>
                                                    <td style="vertical-align: middle;">

                                                        {{ ucfirst($counts['countDasawisma']) }}

                                                    </td>
                                                    <td>

                                                        {{ ucfirst($counts['countRumahTangga']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countKK']) }}
                                                    </td>
                                                    <td>


                                                        {{ ucfirst($counts['countLakiLaki']) }}<br>

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countPerempuan']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countbalitaLaki']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countbalitaPerempuan']) }}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['countPUS']) }}

                                                        {{-- {{ $keluarga->jumlah_PUS }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countWUS']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countIbuHamil']) }}

                                                        {{-- {{ $keluarga->jumlah_ibu_hamil }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countIbuMenyesui']) }}

                                                        {{-- {{ $keluarga->jumlah_ibu_menyusui }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countLansia']) }}
                                                    </td>
                                                    <td>0</td>
                                                    <td>
                                                        {{ ucfirst($counts['countKebutuhanKhusus']) }}

                                                        {{-- {{ $keluarga->jumlah_kebutuhan_khusus }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countKriteriaRumahSehat']) }}

                                                        {{-- @if ($keluarga->kriteria_rumah_sehat == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countKriteriaRumahNonSehat']) }}

                                                        {{-- @if ($keluarga->kriteria_rumah_sehat == '0')
                                                            <i class="fas fa-check"></i>
                                                        @else
0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countTempatSampah']) }}

                                                        {{-- @if ($keluarga->punya_tempat_sampah == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countSPAL']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countJamban']) }}


                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countStiker']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirPDAM']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirSumur']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirLainya']) }}


                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['countBeras']) }}

                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['countNonBeras']) }}

                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['aktivitasUP2K']) }}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['data_pemanfaatan_pekarangan']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['industri_rumah_tangga']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['aktivitasKesehatanLingkungan']) }}

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td><strong>Jumlah</strong> </td>
                                                <td>
                                                    {{-- {{$totalRW}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalRW}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalRT}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalDasawisma}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalJmlKRT}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalJmlKK}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaLaki}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaPerempuan}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaBalitaLaki}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaBalitaPerempuan}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaPUS}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaWUS}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaIbuHamil}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_lansia') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaIbuMenyusui}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_kebutuhan_khusus') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAnggotaLansia}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('kriteria_rumah') }} --}}
                                                </td>
                                                <td>0</td>
                                                <td>
                                                    {{-- {{$totalAnggotaBerkebutuhanKhusus}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalSheatLayakHuni}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalTidakSheatLayakHuni}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('punya_saluran_air') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalPemSampah}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('punya_jamban') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalSPAL}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('tempel_stiker') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalJamban}} --}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalStiker}} --}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 2)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAirPDAM}} --}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 4)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAirSumur}} --}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalAirLainnya}} --}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 0)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalMakanBeras}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('aktivitas_UP2K') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalMakanNonBeras}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('have_pemanfaatan') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalKegiatanUP2K}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('have_industri') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalKegiatanPemanfaatanPekarangan}} --}}
                                                    {{-- {{ $catatan_keluarga->sum('have_kegiatan') }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalKegiatanIndustri}} --}}
                                                </td>
                                                <td>
                                                    {{-- {{$totalKegiatanLingkungan}} --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <a href="{{ url('export_rekap_desa', ['id' => 1]) }}" target="_blank"
                                    class="btn btn-success" type="button" role="button">
                                    <i class="fas fa-print"></i> Cetak ke Excel </a><br>
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
    {{-- <script src="{{url('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{url('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.data').DataTable();
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
