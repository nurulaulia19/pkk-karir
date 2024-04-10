<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Print PDF Data Rekap Data Warga | Kader Dasawisma PKK Kab. Indramayu</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Additional Styles for PDF -->
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
      padding: 8px;
    }
    th {
      background-color: #f2f2f2;
      text-align: center;
    }
    td {
      text-align: center;
    }
    h5 {
      margin-top: 0;
    }
  </style>
</head>
<body>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="container-fluid">
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <h5><strong>Catatan Keluarga</strong></h5>
                            </center>

                            {{-- <div>
                                <p><strong>Catatan Keluarga dari:</strong> {{ $keluarga->nama_kepala_keluarga }}</p>
                                <p><strong>Anggota Kelompok Dasawisma:</strong> matahari</p>
                                <p><strong>Tahun:</strong> 2024</p>
                            </div> --}}
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

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota Keluarga</th>
                                        <th>Status Perkawinan</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir / Umur</th>
                                        <th>Agama</th>
                                        <th>Pendidikan</th>
                                        <th>Pekerjaan</th>
                                        <th>Berkebutuhan Khusus</th>
                                        @foreach ($dataKegiatan as $item)
                                            <th>{{ $item->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($keluarga->anggota as $index => $data_warga)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data_warga->warga->nama }}</td>
                                            <td>{{ $data_warga->warga->status_perkawinan }}</td>
                                            <td>{{ $data_warga->warga->jenis_kelamin }}</td>
                                            <td>{{ $data_warga->warga->tempat_lahir }}</td>
                                            <td>{{ $data_warga->warga->tgl_lahir }} / {{ $data_warga->warga->umur }} Tahun</td>
                                            <td>{{ $data_warga->warga->agama }}</td>
                                            <td>{{ $data_warga->warga->pendidikan }}</td>
                                            <td>{{ $data_warga->warga->pekerjaan }}</td>
                                            <td>{{ $data_warga->warga->berkebutuhan_khusus }}</td>
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

{{-- <!-- jQuery -->
<script src="{{ url('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('admin/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('admin/dist/js/demo.js') }}"></script> --}}
</body>
</html>
