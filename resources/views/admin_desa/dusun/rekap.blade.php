@extends('admin_desa.layout')

@section('title', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok PKK Dusun| Admin Desa/Kelurahan PKK Kab.
    Indramayu')

@section('bread', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok PKK Dusun')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h6><strong>REKAPITULASI</strong></h6>
                                    <h6><strong>CATATAN DATA DAN KEGIATAN WARGA</strong> </h6>
                                    <h6><strong>KELOMPOK PKK DUSUN</strong> </h6>

                                    <h6>Dusun : {{ $dusun_data->name }}</h6>
                                    {{-- @dd($dusun) --}}
                                    <h6>Desa/Kel : {{ $dusun_data->desa->nama_desa }} </h6>
                                    <h6>Tahun : {{ $periode }}</h6>
                                </center>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;">No</th>
                                                <th rowspan="2" style="text-align: center;">No.RW</th>
                                                <th rowspan="2" style="text-align: center;">Jumlah RT</th>
                                                <th rowspan="2" style="text-align: center;">Jumlah Dasa Wisma</th>
                                                <th rowspan="2" style="text-align: center;">Jumlah KRT</th>
                                                <th rowspan="2" style="text-align: center;">Jumlah KK</th>
                                                <th colspan="11" style="text-align:center;">Jumlah Anggota Keluarga</th>
                                                <th colspan="6" style="text-align:center;">Kriteria Rumah</th>
                                                <th colspan="3" style="text-align:center;">Sumber Air Keluarga</th>
                                                {{-- <th rowspan="3" style="text-align:center;">Jumlah Jamban Keluarga</th> --}}
                                                <th colspan="2" style="text-align:center;">Makanan Pokok</th>
                                                <th colspan="6" style="text-align:center;">Warga Mengikuti Kegiatan</th>
                                                {{-- <th rowspan="3" style="text-align: center;">Ket</th> --}}
                                            </tr>
                                            <tr>
                                                <th>Total L</th>
                                                <th>Total P</th>
                                                <th>Balita L</th>
                                                <th>Balita P</th>
                                                <th>3 Buta</th>
                                                {{-- <th>3 Buta P</th> --}}
                                                <th>PUS</th>
                                                <th>WUS</th>
                                                <th>Ibu Hamil</th>
                                                <th>Ibu Menyusui</th>
                                                <th>Lansia</th>
                                                <th>Berkebutuhan Khusus</th>
                                                <th>Sehat Layak Huni</th>
                                                <th>Tidak Sehat Layak Huni</th>
                                                <th>Memiliki Tmp. Pemb. Sampah</th>
                                                <th>Memiliki SPAL</th>
                                                <th>Jumlah Jamban Keluarga</th>
                                                <th>Menempel Stiker P4K</th>
                                                <th>PDAM</th>
                                                <th>Sumur</th>
                                                {{-- <th>Sungai</th> --}}
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
                                            @foreach ($dusun as $dsn)
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{
                                                            $dsn->rw_name
                                                        }}
                                                        {{-- @php
                                                            $counts = app(
                                                                'App\Http\Controllers\AdminDesa\RekapDusunInDesaController',
                                                            )->countRekapitulasiRWInDusun($dsn->id);
                                                        @endphp --}}
                                                        {{-- {{ $rw->rw }} --}}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ count($dsn->rt) }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $dsn->total_dasawisma }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $dsn->total_rumah_tangga }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $dsn->total_jml_kk }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_laki }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_perempuan }}

                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_balita_laki }}

                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_balita_perempuan }}

                                                    </td>
                                                    <td>
                                                        0
                                                    </td>
                                                    {{-- <td>
                                                        0
                                                    </td> --}}
                                                    <td>
                                                        {{ $dsn->total_anggota_pus }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_wus }}

                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_ibu_hamil }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_ibu_menyusui }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_lansia }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_anggota_berkebutuhan_khusus }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_sheat_layak_huni }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_tidak_sheat_layak_huni }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_pem_sampah }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_spal }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_jamban }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_stiker }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_air_pdam }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_air_sumur }}
                                                    </td>
                                                    {{-- <td>
                                                        0
                                                    </td> --}}
                                                    <td>
                                                        {{ $dsn->total_air_lainnya }}
                                                    </td>
                                                    {{-- <td>
                                                        {{ $dsn->total_jamban }}
                                                    </td> --}}
                                                    <td>
                                                        {{ $dsn->total_makan_beras }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_makan_non_beras }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_kegiatan_up2k }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_kegiatan_pemanfaatan_pekarangan }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_kegiatan_industri }}
                                                    </td>
                                                    <td>
                                                        {{ $dsn->total_kesehatan_lingkungan }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"><strong>Jumlah</strong></td>
                                                <td>{{ $totalRt }}</td>
                                                <td>{{ $totalDasawisma }}</td>
                                                <td> {{ $totalRumahTangga }} </td>
                                                <td> {{  $totalJmlKK }} </td>
                                                <td> {{ $totalAnggotaLaki }} </td>
                                                <td> {{ $totalAnggotaPerempuan }} </td>
                                                <td> {{ $totalAnggotaBalitaLaki }} </td>
                                                <td> {{ $totalAnggotaBalitaPerempuan }} </td>
                                                <td> 0 </td>
                                                {{-- <td> 0 </td> --}}
                                                <td> {{ $totalAnggotaPUS }} </td>
                                                <td> {{ $totalAnggotaWUS }} </td>
                                                <td> {{ $totalAnggotaIbuHamil }} </td>
                                                <td> {{ $totalAnggotaIbuMenyusui }} </td>
                                                <td> {{ $totalAnggotaLansia }} </td>
                                                <td> {{ $totalAnggotaBerkebutuhanKhusus }} </td>
                                                <td> {{ $totalSheatLayakHuni }} </td>
                                                <td> {{ $totalTidakSheatLayakHuni }} </td>
                                                <td>{{ $totalPemSampah }}</td>
                                                <td>{{ $totalSPAL }}</td>
                                                <td>{{ $totalJamban }}</td>
                                                <td>{{ $totalStiker }}</td>
                                                <td>{{ $totalAirPDAM }}</td>
                                                <td>{{ $totalAirSumur }}</td>
                                                <td>{{ $totalAirLainnya }}</td>
                                                {{-- <td>{{ $totalJamban }}</td> --}}
                                                <td>{{ $totalMakanBeras }}</td>
                                                <td>{{ $totalMakanNonBeras }}</td>
                                                <td>{{ $totalKegiatanUP2K }}</td>
                                                <td>{{ $totalKegiatanPemanfaatanPekarangan }}</td>
                                                <td>{{ $totalKegiatanIndustri }}</td>
                                                <td>{{ $totalKegiatanLingkungan }}</td>
                                            </tr>
                                        </tfoot>

                                    </table>

                                </div>
                                {{-- <a href="" target="_blank" class="btn btn-success" type="button" role="button">
                                <i class="fas fa-print"></i> Cetak ke Excel </a> --}}
                                <a href="{{ url('export_rekap_dusun',['id' => $dusun_data->id]) }}?periode={{$periode}}" target="_blank" class="btn btn-success mt-2" role="button">
                                    <i class="fas fa-print"></i> Cetak ke Excel
                                </a>
                                <br>
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
            $('.data').DataTable();
        });
    </script>
@endpush
