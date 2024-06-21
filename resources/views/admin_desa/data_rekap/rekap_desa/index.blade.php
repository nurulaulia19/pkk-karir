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
                                    <h6 class="d-flex justify-content-center"><strong>TAHUN {{ $periode }}</strong>
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <h6>Desa/Kel :
                                            {{ $desa->nama_desa }}
                                        </h6>
                                        <h6>Kecamatan :
                                            {{ $desa->kecamatan->nama_kecamatan }}
                                        </h6>
                                        {{-- <h6>Kabupaten :
                                            {{ $dusun->first()->rt->first()->first()->dasawisma->first()->desa->kecamatan->kabupaten->name }}
                                        </h6>
                                        <h6>Provinsi :
                                            {{ $dusun->first()->rt->first()->first()->dasawisma->first()->desa->kecamatan->kabupaten->provinsi->name }}
                                        </h6> --}}
                                        <h6>Kabupaten :
                                            {{ optional($desa->kecamatan->kabupaten)->name ?? 'Indramayu' }}
                                        </h6>
                                        <h6>Provinsi :
                                            {{ optional($desa->kecamatan->kabupaten->provinsi)->name ?? 'Jawa Barat' }}
                                        </h6>
                                    </div>

                                    <div style="margin-bottom: 20px">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="background-color: #50A3B9; color:white">
                                                Rekap
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @foreach ($periodeAll as $item)
                                                    <a class="dropdown-item"
                                                        href="{{ url('rekap_desa') }}?periode={{ $item->tahun }}">{{ $item->tahun }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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
                                                <th>Pemanfaatan Pekarangan</th>
                                                <th>Industri Rumah Tangga</th>
                                                <th>Kesehatan Lingkungan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $hitung = 0;
                                            @endphp
                                            @foreach ($dusun as $dsn)
                                                @php
                                                    $counts = app(
                                                        'App\Http\Controllers\AdminDesa\DusunController',
                                                    )->countDataInDusun($dsn, $periode);
                                                @endphp
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $loop->iteration }}
                                                        @php
                                                            $hitung = $loop->iteration;
                                                        @endphp
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $dsn->name }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $counts['countRw'] }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $counts['countRt'] }}
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

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countKriteriaRumahNonSehat']) }}

                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countTempatSampah']) }}

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
                                            {{-- start non dusun  --}}

                                            {{-- @foreach ($rwsAll as $item)
                                                @php
                                                    $counts = app(
                                                        'App\Http\Controllers\AdminDesa\RekapDusunInDesaController',
                                                    )->rowRwInDesa($item->id);
                                                @endphp
                                                @if ($counts){
                                                    <tr>
                                                        <td style="vertical-align: middle;">
                                                            @php
                                                                $hitung ++ ;
                                                            @endphp
                                                            {{ $hitung }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $counts['nama rw'] }}

                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            1
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $counts['countRt'] }}
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
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countWUS']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countIbuHamil']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countIbuMenyesui']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countLansia']) }}
                                                        </td>
                                                        <td>0</td>
                                                        <td>
                                                            {{ ucfirst($counts['countKebutuhanKhusus']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countKriteriaRumahSehat']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countKriteriaRumahNonSehat']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts['countTempatSampah']) }}
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
                                                }

                                                @endif
                                            @endforeach --}}
                                            {{-- end non dusun  --}}
                                            @foreach ($rwsAll as $item)
                                                @php
                                                    $counts2 = app(
                                                        'App\Http\Controllers\AdminDesa\RekapDusunInDesaController',
                                                    )->rowRtInDesaWrapInRw($item->id, $periode);
                                                    // dd($counts);
                                                @endphp
                                                @if ($counts2)
                                                    <tr>
                                                        <td style="vertical-align: middle;">
                                                            @php
                                                                $hitung++;
                                                            @endphp
                                                            {{ $hitung }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $counts2['nama rw'] }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $counts2['countRw'] }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $counts2['countRt'] }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ ucfirst($counts2['countDasawisma']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countRumahTangga']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countKK']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countLakiLaki']) }}<br>
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countPerempuan']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countbalitaLaki']) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countbalitaPerempuan']) }}
                                                        </td>

                                                        <td>
                                                            {{ ucfirst($counts2['countPUS']) }}

                                                            {{-- {{ $keluarga->jumlah_PUS }} --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countWUS']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countIbuHamil']) }}

                                                            {{-- {{ $keluarga->jumlah_ibu_hamil }} --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countIbuMenyesui']) }}

                                                            {{-- {{ $keluarga->jumlah_ibu_menyusui }} --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countLansia']) }}
                                                        </td>
                                                        <td>0</td>
                                                        <td>
                                                            {{ ucfirst($counts2['countKebutuhanKhusus']) }}

                                                            {{-- {{ $keluarga->jumlah_kebutuhan_khusus }} --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countKriteriaRumahSehat']) }}

                                                            {{-- @if ($keluarga->kriteria_rumah_sehat == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countKriteriaRumahNonSehat']) }}

                                                            {{-- @if ($keluarga->kriteria_rumah_sehat == '0')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countTempatSampah']) }}

                                                            {{-- @if ($keluarga->punya_tempat_sampah == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countSPAL']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countJamban']) }}


                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countStiker']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countAirPDAM']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countAirSumur']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['countAirLainya']) }}


                                                        </td>

                                                        <td>
                                                            {{ ucfirst($counts2['countBeras']) }}

                                                        </td>

                                                        <td>
                                                            {{ ucfirst($counts2['countNonBeras']) }}

                                                        </td>

                                                        <td>
                                                            {{ ucfirst($counts2['aktivitasUP2K']) }}
                                                        </td>

                                                        <td>
                                                            {{ ucfirst($counts2['data_pemanfaatan_pekarangan']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['industri_rumah_tangga']) }}

                                                        </td>
                                                        <td>
                                                            {{ ucfirst($counts2['aktivitasKesehatanLingkungan']) }}

                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td><strong>Jumlah</strong> </td>
                                                <td>
                                                    {{ $totalDusun }}
                                                </td>
                                                <td>
                                                    {{ $totalRw }}
                                                </td>
                                                <td>
                                                    {{ $totalRt }}
                                                </td>
                                                <td>
                                                    {{ $totalDasawisma }}
                                                </td>
                                                <td>
                                                    {{ $totalRumahTangga }}
                                                </td>
                                                <td>
                                                    {{ $totalKeluarga }}
                                                </td>
                                                <td>
                                                    {{ $totalLakiLaki }}
                                                </td>
                                                <td>
                                                    {{ $totalPerempuan }}
                                                </td>
                                                <td>
                                                    {{ $totalbalitaLaki }}
                                                </td>
                                                <td>
                                                    {{ $totalbalitaPerempuan }}
                                                </td>
                                                <td>
                                                    {{ $totalPUS }}
                                                </td>
                                                <td>
                                                    {{ $totalWUS }}
                                                </td>
                                                <td>
                                                    {{ $totalIbuHamil }}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_lansia') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalIbuMenyusui }}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_kebutuhan_khusus') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalLansia }}
                                                    {{-- {{ $catatan_keluarga->sum('kriteria_rumah') }} --}}
                                                </td>
                                                <td>0</td>
                                                <td>
                                                    {{ $totalKebutuhanKhusus }}
                                                </td>
                                                <td>
                                                    {{ $totalRumahSehat }}
                                                </td>
                                                <td>
                                                    {{ $totalRumahNonSehat }}
                                                    {{-- {{ $catatan_keluarga->sum('punya_saluran_air') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalTempatSampah }}
                                                    {{-- {{ $catatan_keluarga->sum('punya_jamban') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalSPAL }}
                                                    {{-- {{ $catatan_keluarga->sum('tempel_stiker') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalJamban }}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalStiker }}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 2)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalAirPDAM }}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 4)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalAirSumur }}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalAirLainya }}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 0)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalBeras }}
                                                    {{-- {{ $catatan_keluarga->sum('aktivitas_UP2K') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalNonBeras }}

                                                    {{-- {{ $catatan_keluarga->sum('have_pemanfaatan') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalAktivitasUP2K }}
                                                </td>
                                                <td>

                                                    {{ $totalPemanfaatanPekarangan }}

                                                    {{-- {{ $catatan_keluarga->sum('have_kegiatan') }} --}}
                                                </td>
                                                <td>
                                                    {{ $totalIndustri }}

                                                    {{-- {{$totalKegiatanIndustri}} --}}
                                                </td>
                                                <td>

                                                    {{ $totalAktivitasLingkungan }}

                                                    {{-- {{$totalKegiatanLingkungan}} --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <a href="{{ url('export_rekap_desa', ['id' => $desa->id]) }}?periode={{ $periode }}"
                                    target="_blank" class="btn btn-success mt-2" type="button" role="button">
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
