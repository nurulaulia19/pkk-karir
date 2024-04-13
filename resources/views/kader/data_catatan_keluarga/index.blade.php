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
                                        <h6>CATATAN KELUARGA DARI : {{ $keluarga->nama_kepala_keluarga }}</h6>
                                        <h6>ANGGOTA KELOMPOK DASAWISMA : {{ $dasawisma->nama_dasawisma }}</h6>
                                        <h6>TAHUN : {{ $keluarga->periode }}</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        {{-- Kriteria Rumah --}}
                                        {{-- @if ($rumahTangga->punya_jamban && $rumahTangga->punya_tempat_sampah)
                                        <h6>KRITERIA RUMAH : LAYAK HUNI</h6>
                                        @else
                                        <h6>KRITERIA RUMAH : TIDAK LAYAK HUNI</h6>
                                        @endif --}}
                                        @if ($rumahTangga->kriteria_rumah_sehat)
                                        <h6>KRITERIA RUMAH : LAYAK HUNI</h6>
                                        @else
                                        <h6>KRITERIA RUMAH : TIDAK LAYAK HUNI</h6>
                                        @endif

                                        {{-- Jamban keluarga --}}
                                        @if ($rumahTangga->punya_jamban)
                                        <h6>JAMBAN KELUARGA : ADA / {{ $rumahTangga->punya_jamban }} buah</h6>
                                        @else
                                        <h6>JAMBAN KELUARGA : TIDAK</h6>
                                        @endif

                                        {{-- sumber air --}}
                                        <div style="display: flex; align-items: center;">
                                            <h6 style="margin-right: 10px;">SUMBER AIR :</h6>
                                            <div style="display: flex; flex-wrap: wrap; align-items: flex-start;">
                                                @if ($rumahTangga->sumber_air_pdam)
                                                    <span style="margin-right: 5px; margin-bottom: 7px;">PDAM</span>
                                                @endif
                                                @if ($rumahTangga->sumber_air_sumur)
                                                    <span style="margin-right: 5px; margin-bottom: 7px;">SUMUR</span>
                                                @endif
                                                @if ($rumahTangga->sumber_air_lainnya)
                                                    <span style="margin-right: 5px; margin-bottom: 7px;">LAINNYA</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- tempat sampah --}}
                                        @if ($rumahTangga->punya_tempat_sampah == 1)
                                            <h6>TEMPAT SAMPAH : ADA</h6>
                                        @else
                                            <h6>TEMPAT SAMPAH : TIDAK</h6>
                                        @endif
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
                                                <th colspan="{{ count($dataKegiatan) }}" style="padding: 0; margin: 0;">
                                                    <center>Kegiatan Yang diikuti</center>
                                                    <table style="width: 100%; table-layout: fixed;">
                                                        <colgroup>
                                                            @php
                                                                $columnWidth = 130; // Atur lebar setiap kolom menjadi 200px
                                                            @endphp
                                                            @for ($i = 0; $i < count($dataKegiatan); $i++)
                                                                <col style="width: {{ $columnWidth }}px;">
                                                            @endfor
                                                        </colgroup>
                                                        <tr style="background-color: white">
                                                            @foreach ($dataKegiatan as $item)
                                                                <th style="vertical-align: middle; text-align: center; padding: 5px;">
                                                                    {{ $item->name }}
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                    </table>
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
                                                    {{-- @foreach ($dataKegiatan as $item)

                                                        @php
                                                            $ada = false;
                                                        @endphp
                                                        @foreach ($data_warga->warga->kegiatan as $kegiatan)
                                                            @if ($item->id == $kegiatan->data_kegiatan_id )
                                                                @php
                                                                $ada = true;
                                                            @endphp
                                                            @endif

                                                        @endforeach
                                                        <td style="vertical-align: middle; width:130px;">
                                                            {{ $ada ? '1' : '' }}
                                                        </td>
                                                        @php
                                                            $ada = false;
                                                        @endphp
                                                    @endforeach --}}
                                                    @foreach ($dataKegiatan as $item)
                                                        @php
                                                            $ada = false;
                                                        @endphp
                                                        @foreach ($data_warga->warga->kegiatan as $kegiatan)
                                                            @if ($item->id == $kegiatan->data_kegiatan_id)
                                                                @php
                                                                    $ada = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <td style="vertical-align: middle; width: 130px;">
                                                            @if ($ada)
                                                                ✓
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                    {{-- <a href="{{ url('print_pdf_cakel', $keluarga->id) }}" target="_blank" class="btn btn-success" type="button" role="button">
                                        <i class="fas fa-print"></i> Cetak ke PDF
                                    </a> --}}
                                    {{-- <a href="{{ url('print_excel_cakel', $keluarga->id) }}" target="_blank" class="btn btn-success" role="button">
                                        <i class="fas fa-print"></i> Cetak ke Excel
                                    </a><br> --}}
                                    <td class="text-center">
                                        <a class="btn btn-success" href="{{ url('print_excel_cakel', $keluarga->id) }}?{{ http_build_query([
                                            'nama_dasawisma' => $dasawisma->nama_dasawisma, // Use the correct attribute name
                                            'rt' => $keluarga->rt,
                                            'rw' => $keluarga->rw,
                                            'periode' => $keluarga->periode,
                                        ]) }}"><i class="fas fa-print"></i> Cetak ke Excel</a>
                                    </td>

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
