@extends('admin_kab.layout')

@section('title', 'Catatan Data Dan Kegiatan Warga Kelompok PKK Kabupaten | Admin Kabupaten PKK Kab. Indramayu')

@section('bread', 'Catatan Data Dan Kegiatan Warga Kelompok PKK Kabupaten')
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
                                <h6><strong>CATATAN DATA KEGIATAN WARGA</strong></h6>
                                <h6><strong>TP PKK KABUPATEN</strong></h6>
                                <h6><strong>TAHUN {{$periode}}</strong></h6>
                                <h6><strong>KAB/KOTA : {{ strtoupper($kecamatans->first()->kabupaten->name ?? 'INDRAMAYU') }}</strong></h6>
                                <h6><strong>PROVINSI : {{ strtoupper($kecamatans->first()->kabupaten->provinsi->name ?? 'JAWA BARAT') }}</strong></h6>
                            </center>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                    <thead>
                                        <tr>
                                        <th rowspan="3" style="text-align: center;">No</th>
                                        <th rowspan="3" style="text-align: center;">Nama Kecamatan</th>
                                        <th rowspan="3" style="text-align: center;">Jml. Desa/Kel</th>
                                        <th rowspan="3" style="text-align: center;">Jml. RW</th>
                                        <th rowspan="3" style="text-align: center;">Jml. RT</th>
                                        <th rowspan="3" style="text-align: center;">Jml. Dasa Wisma</th>
                                        <th rowspan="3" style="text-align: center;">Jml. KRT</th>
                                        <th rowspan="3" style="text-align: center;">Jml. KK</th>
                                        <th colspan="11" style="text-align:center;">Jumlah Anggota Keluarga</th>
                                        <th colspan="6" style="text-align:center;">Kriteria Rumah</th>
                                        <th colspan="3" style="text-align:center;">Sumber Air Keluarga</th>
                                        {{-- <th rowspan="3" style="text-align: center;">Jml. Jamban Keluarga</th> --}}
                                        <th colspan="2" style="text-align:center;">Makanan Pokok</th>
                                        <th colspan="6" style="text-align:center;">Warga Mengikuti Kegiatan</th>
                                        {{-- <th rowspan="3" style="text-align: center;">Ket</th> --}}
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

                                    {{-- <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                    </tr> --}}
                                    </thead>

                                    <tbody>
                                        @foreach ($kecamatans as $kec)
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                {{ $kec->nama_kecamatan }}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                @php
                                                    $counts = app(
                                                        'App\Http\Controllers\AdminKabController',
                                                    )->countRekapitulasiDesaInKecamatan($kec->id, $periode);
                                                @endphp
                                                {{ ucfirst($counts['totalDesa']) }}

                                                {{-- {{ $kec->jumlah_desa }} --}}
                                            </td>

                                            <td style="vertical-align: middle;">
                                                {{ ucfirst($counts['countRW']) }}
                                                {{-- {{ $kec->jumlah_rw }} --}}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                {{-- {{ $kec->jumlah_rt }} --}}
                                                {{ ucfirst($counts['rt']) }}

                                            </td>
                                            <td style="vertical-align: middle;">
                                                {{ ucfirst($counts['countDasawisma']) }}

                                                {{-- {{ $kec->jumlah_dasa_wisma }} --}}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                {{ ucfirst($counts['countRumahTangga']) }}

                                                {{-- {{ $kec->jumlah_KRT }} --}}
                                            </td>
                                            <td style="vertical-align: middle;">
                                                {{ ucfirst($counts['countKK']) }}

                                                {{-- {{ $kec->jumlah_KK }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['laki_laki']) }}<br>

                                                {{-- {{ $kec->jumlah_laki_laki }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['perempuan']) }}

                                                {{-- {{ $kec->jumlah_perempuan }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['balitaLaki']) }}

                                                {{-- {{ $kec->jumlah_balita_laki }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['balitaPerempuan']) }}

                                                {{-- {{ $kec->jumlah_balita_perempuan }} --}}
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

                                                {{-- {{ $kec->jumlah_kriteria_rumah_tidak_sehat }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['tempatSampah']) }}

                                                {{-- {{ $kec->jumlah_punya_tempat_sampah }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countSPAL']) }}

                                                {{-- {{ $kec->jumlah_punya_saluran_air }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countJamban']) }}

                                                {{-- {{ $kec->punya_jamban }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countStiker']) }}

                                                {{-- {{ $kec->jumlah_tempel_stiker }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countAirPDAM']) }}

                                                {{-- {{ $kec->jumlah_sumber_air_pdam }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countAirSumur']) }}

                                                {{-- {{ $kec->jumlah_sumber_air_sumur }} --}}
                                            </td>
                                            <td>
                                                {{ ucfirst($counts['countAirLainya']) }}

                                                {{-- {{ $kec->jumlah_sumber_air_sungai }} --}}
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

                                                {{-- {{ $kec->jumlah_have_pemanfaatan }} --}}
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
                                            <td colspan="2"><strong>Jumlah</strong></td>
                                            <td>{{ $totalDesa }}</td>
                                            <td>{{ $totalRw }}</td>
                                            <td>{{ $totalRt }}</td>
                                            <td>{{ $totalDasawisma}}</td>
                                            <td>{{ $totalRumahTangga }}</td>
                                            <td>{{ $totalKK }}</td>
                                            <td>{{ $totalLakiLaki}}</td>
                                            <td>{{ $totalPerempuan }}</td>
                                            <td>{{ $totalBalitaLaki}}</td>
                                            <td>{{ $totalbalitaPerempuan }}</td>
                                            {{-- <td>{{ $kecamatans->sum('jumlah_3_buta_laki') }}</td> --}}
                                            {{-- <td>{{ $kecamatans->sum('jumlah_3_buta_perempuan') }}</td> --}}
                                            <td>{{ $totalPUS }}</td>
                                            <td>{{ $totalWUS }}</td>
                                            <td>{{ $totalIbuHamil }}</td>
                                            <td>{{ $totalIbuMenyesui }}</td>
                                            <td>{{ $totalLansia }}</td>
                                            <td>0</td>
                                            <td>{{ $totalKebutuhanKhusus }}</td>
                                            <td>{{ $totalKriteriaRumahSehat }}</td>
                                            <td>{{ $totalKriteriaRumahNonSehat}}</td>
                                            <td>{{ $totalTempatSampah }}</td>
                                            <td>{{ $totalSPAL }}</td>
                                            <td>{{ $totalJamban }}</td>
                                            <td>{{ $totalStiker }}</td>
                                            <td>{{ $totalAirPDAM }}</td>
                                            <td>{{ $totalAirSumur }}</td>
                                            <td>{{ $totalAirLainya }}</td>
                                            <td>{{ $totalBeras }}</td>
                                            <td>{{ $totalNonBeras }}</td>
                                            <td>{{ $totalAaktivitasUP2K}}</td>
                                            <td>{{ $totalPemanfaatanPekarangan }}</td>
                                            <td>{{ $totalIndustri}}</td>
                                            <td>{{ $totalAktivitasKesehatanLingkungan }}</td>
                                            {{-- <td>{{ $kecamatans->sum('jumlah_have_industri') }}</td> --}}
                                            {{-- <td>{{ $kecamatans->sum('jumlah_have_kegiatan') }}</td> --}}
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <a href="{{ url('export_rekap_kab') }}?periode={{$periode}}" target="_blank" class="btn btn-success" type="button" role="button">
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
$(document).ready( function () {
    $('.data').DataTable();
} );
</script>



@endpush
