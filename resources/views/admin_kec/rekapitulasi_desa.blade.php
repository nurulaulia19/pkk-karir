@extends('admin_kab.layout')

@section('title', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Kecamatan | Admin TP PKK Kab.
    Indramayu')

@section('bread', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok Kecamatan')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h6 class="d-flex justify-content-center"><strong>REKAPITULASI</strong></h6>
                                    <h6 class="d-flex justify-content-center"><strong>CATATAN DATA DAN KEGIATAN WARGA</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>KELOMPOK DESA/KELURAHAN</strong> </h6>
                                    <h6 class="d-flex justify-content-center"><strong>TAHUN {{$desaa->first()->dasawisma->first()->periode}}</strong> </h6>
                                </div>
                                <div>
                                    <h6>Desa/Kel :
                                        {{-- {{ $dasa_wisma->first()->dasawisma->first()->desa->nama_desa }} --}}
                                    </h6>
                                    <h6>Kecamatan :
                                        {{-- {{ $dasa_wisma->first()->dasawisma->first()->desa->kecamatan->nama_kecamatan }} --}}
                                    </h6>
                                    <h6>Kabupaten :
                                        {{-- {{ $dasa_wisma->first()->dasawisma->first()->desa->kecamatan->kabupaten->name }} --}}
                                    </h6>
                                    <h6>Provinsi :
                                        {{-- {{ $dasa_wisma->first()->dasawisma->first()->desa->kecamatan->kabupaten->provinsi->name }} --}}
                                    </h6>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;">No</th>
                                                <th rowspan="2" style="text-align: center;">Nama desa</th>
                                                <th rowspan="2" style="text-align: center;">Jml RW</th>
                                                <th rowspan="2" style="text-align: center;">Jml RT</th>
                                                <th rowspan="2" style="text-align: center;">Jml Dasawisma</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KRT</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KK</th>
                                                <th colspan="11" style="text-align:center;">Jumlah Anggota Keluarga</th>
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
                                                            )->countRekapitulasiRWInDesa($desa->id);
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
                                                <td><strong>Jumlah</strong> </td>
                                                <td>
                                                    {{$totalDesa}}
                                                </td>
                                                <td>
                                                    {{$totalRW}}
                                                </td>
                                                <td>
                                                    {{$totalRT}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_KK') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalDasawisma}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_laki') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalJmlKRT}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_perempuan') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalJmlKK}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_balita_laki') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaLaki}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_balita_perempuan') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaPerempuan}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_3_buta') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaBalitaLaki}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_PUS') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaBalitaPerempuan}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_WUS') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaPUS}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_ibu_hamil') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaWUS}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_ibu_menyusui') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaIbuHamil}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_lansia') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaIbuMenyusui}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_kebutuhan_khusus') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaLansia}}
                                                    {{-- {{ $catatan_keluarga->sum('kriteria_rumah') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAnggotaBerkebutuhanKhusus}}
                                                    {{-- {{ $catatan_keluarga->count() - $catatan_keluarga->sum('kriteria_rumah') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalSheatLayakHuni}}
                                                    {{-- {{ $catatan_keluarga->sum('punya_tempat_sampah') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalTidakSheatLayakHuni}}
                                                    {{-- {{ $catatan_keluarga->sum('punya_saluran_air') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalPemSampah}}
                                                    {{-- {{ $catatan_keluarga->sum('punya_jamban') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalSPAL}}
                                                    {{-- {{ $catatan_keluarga->sum('tempel_stiker') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalJamban}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalStiker}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 2)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAirPDAM}}
                                                    {{-- {{ $catatan_keluarga->where('sumber_air', 4)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAirSumur}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalAirLainnya}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 0)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalMakanBeras}}
                                                    {{-- {{ $catatan_keluarga->sum('aktivitas_UP2K') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalMakanNonBeras}}
                                                    {{-- {{ $catatan_keluarga->sum('have_pemanfaatan') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanUP2K}}
                                                    {{-- {{ $catatan_keluarga->sum('have_industri') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanPemanfaatanPekarangan}}
                                                    {{-- {{ $catatan_keluarga->sum('have_kegiatan') }} --}}
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
                                <a href="{{ url('export_rekap_desa',['id' => $desaa->first()->id ]) }}" target="_blank" class="btn btn-success" type="button" role="button">
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
