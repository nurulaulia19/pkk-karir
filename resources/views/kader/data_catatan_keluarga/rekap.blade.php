@extends('kader.layout')

@section('title', 'Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Keluarga')
@section('container')

    <!-- Main content -->
<div class="main-content">
    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data" id="add-row">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-md-1">
                                            <a href="{{ url('data_keluarga/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                        </div>
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pilihan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($dataPeriode as $item)
                                                        <a class="dropdown-item" href="{{ url('catatan_keluarga?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kepala Keluarga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keluarga as $c)
                                    <tr>
                                        <td style="vertical-align: middle; position: relative;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{ucfirst($c->nama_kepala_keluarga) }}
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm" href="{{ url('rekap_data_warga/'.$c->id.'/rekap_data_warga') }}">Rekap Data Warga</a>
                                            <a href="{{ route('keluarga-detail',['id' => $c->id]) }}" class="btn btn-warning btn-sm" >
                                                Catatan Keluarga
                                            </a>
                                        </td>

                                    </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                                @foreach ($keluarga as $c)
                                <div id="details-modal-{{ $c->id }}" class="modal fade" tabindex="1" role="dialog" aria-labelledby="details-modal-{{ $c->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Details</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                                    <div class="modal-body">
                                                    <h5>
                                                        Dasawisma : <strong>
                                                            {{-- {{ucfirst($c->dasawisma->nama_dasawisma) }} --}}
                                                         </strong><br>
                                                        RT <strong>
                                                            {{-- {{ ($c->rt) }} --}}
                                                        </strong>, RW <strong>
                                                            {{-- {{ ($c->rt) }} --}}
                                                        </strong> <br>
                                                        Dusun : <br>
                                                        Desa/Kel : <strong>
                                                            {{-- {{ucfirst($c->desa->nama_desa)}} --}}
                                                        </strong><br>
                                                        Kec. <strong>
                                                            {{-- {{ucfirst($c->kecamatan->nama_kecamatan)}} --}}
                                                        </strong>,
                                                            Kabupaten <strong>
                                                                {{-- {{ucfirst($c->kabupaten) }} --}}
                                                            </strong>, Provinsi <strong>
                                                                {{-- {{ucfirst($c->provinsi) }} --}}
                                                            </strong><br>
                                                        Nama Kepala Rumah Tangga : <strong>
                                                            {{-- {{ucfirst($c->nama_kepala_rumah_tangga) }} --}}
                                                        </strong><br>
                                                        Jumlah Anggota Keluarga : <strong>
                                                            {{-- {{ucfirst($c->jumlah_anggota_keluarga) }} --}}
                                                        </strong>Orang<br>

                                                        Jumlah Balita :  2 orang <br>
                                                        Jumlah PUS (Pasangan Usia Subur) :  2 orang <br>
                                                        Jumlah WUS (Wanita Usia Subur) :  2 orang <br>
                                                        Jumlah 3 Buta (Buta Warna, Buta Baca, Buta Hitung):  2 orang<br>
                                                        Jumlah Ibu Hamil :  2 orang<br>
                                                        Jumlah Ibu Menyusui : 2 orang <br>
                                                        Jumlah  Lansia :  2 orang<br>
                                                        Jumlah Kebutuhan Khusus :2 orang <br>

                                                            Makanan Pokok Sehari-hari: <strong> Beras </strong><br>

                                                            Mempunyai Jamban Keluarga: <strong> Ya/ 2 Buah</strong><br>


                                                            Sumber Air Keluarga: <strong> PDAM</strong><br>


                                                            Memiliki Tempat Pembuangan Sampah: <strong> Ya</strong><br>


                                                            Mempunyai Saluran Pembuangan Air Limbah: <strong> Ya</strong><br>


                                                            Menempel Stiker P4K: <strong> Ya</strong><br>


                                                            Kriteria Rumah : <strong>Sehat</strong><br>


                                                            Aktivitaser UP2K: <strong> Ya</strong><br>

                                                            Aktivitas Kegiatan Usaha Kesehatan Lingkungan: <strong> Ya</strong><br>

                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
                                                        {{-- <button type="button" class="btn btn-primary">Oke</button> --}}
                                                    </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach


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
$(document).ready( function () {
    $('.data').DataTable();
} );
</script>
<script>
    $('.delete').click(function(event) {
          var form =  $(this).closest("form");
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
