@extends('kader.layout')

@section('title', 'Catatan Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Catatan Keluarga ')
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
                                    <h5><strong> Catatan Keluarga </strong></h5>
                                </center>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>Catatan Keluarga dari : {{ $keluarga->nama_kepala_keluarga }}</h6>
                                        <h6>Anggota Kelompok Dasawisma : {{ $keluarga->dasawisma->nama_dasawisma }}</h6>
                                        <h6>Tahun : 2024</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        {{-- kriteria rumah --}}
                                        {{-- @if (x) --}}
                                        <h6>Kriteria Rumah : Sehat</h6>
                                        {{-- @else
                                        <h6>Kriteria Rumah : Kurang Sehat</h6>
                                    @endif --}}

                                        {{-- jamban keluarga --}}
                                        {{-- @if (x) --}}
                                        <h6>Jamban Keluarga : Ya/  {{ $keluarga->punya_jamban }} buah</h6>
                                        {{-- @else
                                        <h6>Jamban Keluarga : Tidak</h6>
                                    @endif --}}

                                        {{-- sumber air --}}
                                        {{-- @if ($keluarga->sumber_air == 1) --}}
                                        <h6>Sumber Air : PDAM</h6>
                                        {{-- @elseif ($keluarga->sumber_air == 2)
                                        <h6>Sumber Air : Sumur</h6>
                                    @elseif ($keluarga->sumber_air == 3)
                                        <h6>Sumber Air : Sungai</h6>
                                    @elseif ($keluarga->sumber_air == 4)
                                        <h6>Sumber Air : Lainnya</h6>
                                    @endif --}}

                                        {{-- tempat sampah --}}
                                        {{-- @if ($keluarga->punya_tempat_sampah == 1) --}}
                                        <h6>Tempat Sampah : Ya</h6>
                                        {{-- @else
                                        <h6>Tempat Sampah : Tidak</h6>
                                    @endif --}}
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered data" id="add-row">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Nama Anggota Keluarga</th>
                                                <th rowspan="2">Status Perkawinan</th>
                                                <th rowspan="2">Jenis Kelamin</th>
                                                <th rowspan="2">Tempat Lahir</th>
                                                <th rowspan="2">Tanggal Lahir/Umur</th>
                                                <th rowspan="2">Agama</th>
                                                <th rowspan="2">Pendidikan</th>
                                                <th rowspan="2">Pekerjaan</th>
                                                <th rowspan="2">Berkebutuhan Khusus</th>
                                                <th colspan="8">
                                                    <center>Kegiatan Yang diikuti</center>
                                                </th>
                                                {{-- <th rowspan="2">Ket</th> --}}
                                            </tr>

                                            <tr>
                                                {{-- @foreach ($kategori_kegiatans as $kategori_kegiatan)
                                                <th>{{ $kategori_kegiatan->nama_kegiatan }}</th>
                                            @endforeach --}}
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($keluarga->anggota as $index =>$data_warga)
                                                <tr>
                                                    <td style="vertical-align: middle;"> {{$index+1}} </td>
                                                    <td style="vertical-align: middle;">{{ $data_warga->warga->nama }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_warga->warga->status_perkawinan }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_warga->warga->jenis_kelamin }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_warga->warga->tempat_lahir }}</td>
                                                        @php
                                                            // Memeriksa apakah tanggal lahir telah di-set
                                                            $tgl_lahir = $data_warga->warga->tgl_lahir;
                                                            $umur = '-';
                                                            if ($tgl_lahir) {
                                                                // Menggunakan Carbon untuk menghitung umur jika tanggal lahir telah di-set
                                                                $umur = \Carbon\Carbon::parse($tgl_lahir)->age;
                                                            }
                                                        @endphp

                                                    <td style="vertical-align: middle;">{{$data_warga->warga->tgl_lahir}} / {{ $umur }} Tahun</td>

                                                    </td>
                                                    <td style="vertical-align: middle;">{{ $data_warga->warga->agama }}</td>
                                                    <td style="vertical-align: middle;">{{ $data_warga->warga->pendidikan }}
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ $data_warga->warga->pekerjaan }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_warga->warga->berkebutuhan_khusus }}
                                                    </td>
                                                    {{--
                                                    @foreach ($kategori_kegiatans as $kategori_kegiatan)

                                                        <td>
                                                            @if ($data_kegiatan_wargas = $data_warga->kegiatan)
                                                                <ul>
                                                                    @foreach ($data_kegiatan_wargas as $data_kegiatan_warga)
                                                                        @if ($data_kegiatan_warga->kategori_kegiatan->id === $kategori_kegiatan->id)
                                                                            <li>{{ $data_kegiatan_warga->keterangan_kegiatan->nama_keterangan }}</li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>

                                                    @endforeach --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <a href="" target="_blank" class="btn btn-success" type="button" role="button">
                                        <i class="fas fa-print"></i> Cetak ke PDF </a><br>
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
            $('.data').DataTable();
        });
    </script>
@endpush
