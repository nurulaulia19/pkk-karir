@extends('admin_kab.layout')

@section('title', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Kecamatan | Admin TP PKK Kab.
    Indramayu')

@section('bread', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Kecamatan')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <style>
            th, td {
            text-align: center !important;
            vertical-align: middle !important;
        }
        </style>
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h6 class="d-flex justify-content-center"><strong>REKAPITULASI</strong></h6>
                                    <h6 class="d-flex justify-content-center"><strong>CATATAN DATA DAN KEGIATAN WARGA</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>KELOMPOK KECAMATAN</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>TAHUN {{$periode}}</strong> </h6>
                                </div>
                                <div>

                                    <h6>Kecamatan :
                                        {{ $kecamatan->nama_kecamatan }}
                                    </h6>
                                    <h6>Kabupaten :
                                        {{ optional($kecamatan->kabupaten)->name ?? 'Indramayu' }}
                                    </h6>
                                    <h6>Provinsi :
                                        {{ optional($kecamatan->kabupaten->provinsi)->name ?? 'Jawa Barat' }}
                                    </h6>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center; ">No</th>
                                                <th rowspan="2" style="text-align: center;">Nama desa</th>
                                                <th rowspan="2" style="text-align: center;">Jml RW</th>
                                                <th rowspan="2" style="text-align: center;">Jml RT</th>
                                                <th rowspan="2" style="text-align: center;">Jml Dasawisma</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KRT</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KK</th>
                                                <th colspan="11" style="text-align:center;">Jumlah Anggota Keluarga</th>
                                                <th colspan="6" style="text-align:center;">Kriteria Rumah</th>
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
                                                <th>Sehat</th>
                                                <th>Kurang Sehat</th>
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
                                                <th>Pemanfaatan Pekarangan</th>
                                                <th>Industri Rumah Tangga</th>
                                                <th>Kesehatan Lingkungan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($desaa as $desa)

                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $desa->nama_desa }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @php
                                                            $counts = app(
                                                                'App\Http\Controllers\AdminKabController',
                                                            )->countRekapitulasiRWInDesa($desa->id,$periode);
                                                        @endphp
                                                       {{ ucfirst($counts['countRW']) }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ ucfirst($counts['rt']) }}
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


                                                        {{ ucfirst($counts['laki_laki']) }}<br>

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['perempuan']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['balitaLaki']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['balitaPerempuan']) }}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['pus']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['wus']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['ibuHamil']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['ibuMenyusui']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['lansia']) }}
                                                    </td>
                                                    <td>0</td>
                                                    <td>
                                                        {{ ucfirst($counts['kebutuhanKhusus']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['rumahSehat']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['rumahNonSehat']) }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['tempatSampah']) }}
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
                                                        {{ ucfirst($counts['pemanfaatanPekarangan']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['industriRumahTangga']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['kesehatanLingkungan']) }}

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2"><strong>Jumlah</strong> </td>
                                                <td style="display: none"></td>
                                                <td>
                                                    {{$totalRW}}
                                                </td>
                                                <td>
                                                    {{$totalRT}}
                                                </td>
                                                <td>
                                                    {{$totalDasawisma}}
                                                </td>
                                                <td>
                                                    {{$totalJmlKRT}}
                                                </td>
                                                <td>
                                                    {{$totalJmlKK}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaLaki}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaPerempuan}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaBalitaLaki}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaBalitaPerempuan}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaPUS}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaWUS}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaIbuHamil}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaIbuMenyusui}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaLansia}}
                                                </td>
                                                <td>0</td>
                                                <td>
                                                    {{$totalAnggotaBerkebutuhanKhusus}}
                                                </td>
                                                <td>
                                                    {{$totalSheatLayakHuni}}
                                                </td>
                                                <td>
                                                    {{$totalTidakSheatLayakHuni}}
                                                </td>
                                                <td>
                                                    {{$totalPemSampah}}
                                                </td>
                                                <td>
                                                    {{$totalSPAL}}
                                                </td>
                                                <td>
                                                    {{$totalJamban}}
                                                </td>
                                                <td>
                                                    {{$totalStiker}}
                                                </td>
                                                <td>
                                                    {{$totalAirPDAM}}
                                                </td>
                                                <td>
                                                    {{$totalAirSumur}}
                                                </td>
                                                <td>
                                                    {{$totalAirLainnya}}
                                                </td>
                                                <td>
                                                    {{$totalMakanBeras}}
                                                </td>
                                                <td>
                                                    {{$totalMakanNonBeras}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanUP2K}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanPemanfaatanPekarangan}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanIndustri}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanLingkungan}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ url('export_rekap_kec',['id' => $desaa->first()->id_kecamatan ]) }}?periode={{$periode}}" target="_blank" class="btn btn-success mt-2" type="button" role="button">
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

