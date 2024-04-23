@extends('admin_desa.layout')

@section('title', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok PKK RW | Admin Desa/Kelurahan PKK Kab.
    Indramayu')

@section('bread', 'Rekapitulasi Catatan Data Dan Kegiatan Warga Kelompok PKK RW')
@section('container')

    <!-- Main content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h6><strong>REKAPITULASI</strong></h6>
                                    <h6><strong>CATATAN DATA DAN KEGIATAN WARGA</strong> </h6>
                                    <h6><strong>KELOMPOK PKK RW</strong> </h6>

                                    {{-- <h6>RT :
                                        {{ $dasa_wisma->first()->rt->name }}
                                    </h6> --}}
                                    <h6>RW :
                                        {{ $dasa_wisma->first()->rw->name }}
                                    </h6>
                                    <h6>Desa/Kel :
                                        {{ $dasa_wisma->first()->desa->nama_desa }}

                                    </h6>
                                    <h6>Tahun :
                                        {{ $dasa_wisma->first()->periode }}

                                    </h6>
                                </center>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row" width="6000px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;">No</th>
                                                <th rowspan="2" style="text-align: center;">kode RT</th>
                                                <th rowspan="2" style="text-align: center;">Nama Dasawisma</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KRT</th>
                                                <th rowspan="2" style="text-align: center;">Jml. KK</th>
                                                <th colspan="10" style="text-align:center;">Jumlah Anggota Keluarga</th>
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
                                            @foreach ($dasa_wisma as $desa)
                                            @php
                                                $keluarga = $desa->keluarga;
                                            @endphp

                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $desa->rt->name }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $desa->nama_dasawisma  }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $counts = app(
                                                                'App\Http\Controllers\AdminController',
                                                            )->countRekapitulasiDasawismaInRt($desa->id);
                                                        @endphp
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

                                                        {{-- {{ $keluarga->jumlah_PUS }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['wus']) }}

                                                        {{-- {{ $keluarga->jumlah_WUS }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['ibuHamil']) }}

                                                        {{-- {{ $keluarga->jumlah_ibu_hamil }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['ibuMenyusui']) }}

                                                        {{-- {{ $keluarga->jumlah_ibu_menyusui }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['lansia']) }}

                                                        {{-- {{ $keluarga->jumlah_lansia }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['kebutuhanKhusus']) }}

                                                        {{-- {{ $keluarga->jumlah_kebutuhan_khusus }} --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['rumahSehat']) }}

                                                        {{-- @if ($keluarga->kriteria_rumah_sehat == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['rumahNonSehat']) }}

                                                        {{-- @if ($keluarga->kriteria_rumah_sehat == '0')
                                                            <i class="fas fa-check"></i>
                                                        @else
0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['tempatSampah']) }}

                                                        {{-- @if ($keluarga->punya_tempat_sampah == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countSPAL']) }}

                                                        {{-- @if ($keluarga->saluran_pembuangan_air_limbah == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countJamban']) }}

                                                        {{-- @if ($keluarga->punya_jamban == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countStiker']) }}

                                                        {{-- @if ($keluarga->tempel_stiker == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirPDAM']) }}

                                                        {{-- @if ($keluarga->sumber_air_pdam == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                        0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirSumur']) }}

                                                        {{-- @if ($keluarga->sumber_air_sumur == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['countAirLainya']) }}

                                                        {{-- @if ($keluarga->sumber_air_lainnya == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['countBeras']) }}

                                                        {{-- @if ($keluarga->makanan_pokok == '1')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                        {{-- {{ ucfirst($counts['MakanBeras']) }} --}}

                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['countNonBeras']) }}

                                                        {{-- {{ ucfirst($counts['MakanNonBeras']) }} --}}
                                                        {{-- @if ($keluarga->makanan_pokok == '0')
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['aktivitasUP2K']) }}
                                                    </td>

                                                    <td>
                                                        {{ ucfirst($counts['pemanfaatanPekarangan']) }}

                                                        {{-- @if ($keluarga->pemanfaatan->count() > 0)
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['industriRumahTangga']) }}

                                                        {{-- @if ($keluarga->industri->count() > 0)
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($counts['kesehatanLingkungan']) }}


                                                        {{-- @if ($keluarga->getKepalaKeluargaKegiatans()->count() > 0)
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            0
                                                        @endif --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2"><strong>Jumlah</strong> </td>
                                                {{-- <td>{{$totalRT}}</td> --}}
                                                <td>
                                                    {{$totalDasawisma}}
                                                    {{-- {{ $catatan_keluarga->sum('jumlah_KK') }} --}}
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

                                                </td>
                                                <td>
                                                    {{$totalAirSumur}}

                                                </td>
                                                <td>
                                                    {{$totalAirLainnya}}
                                                </td>
                                                <td>
                                                    {{$totalMakanBeras}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 1)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalMakanNonBeras}}
                                                    {{-- {{ $catatan_keluarga->where('makanan_pokok', 0)->count() }} --}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanUP2K}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanPemanfaatanPekarangan}}
                                                    {{-- {{ $catatan_keluarga->sum('have_pemanfaatan') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanIndustri}}
                                                    {{-- {{ $catatan_keluarga->sum('have_industri') }} --}}
                                                </td>
                                                <td>
                                                    {{$totalKegiatanLingkungan}}
                                                    {{-- {{ $catatan_keluarga->sum('have_kegiatan') }} --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <a href="{{ url('export_rekap_rw',['id' => $dasa_wisma->first()->rw->id ]) }}" target="_blank" class="btn btn-success" type="button" role="button">
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
