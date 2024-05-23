@extends('kader.layout')

@section('title', 'Data Pemanfaatan Tanah Pekarangan | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Pemanfaatan Tanah Pekarangan ')
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
                                            <a href="{{ url('data_pemanfaatan/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                        </div>
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pilihan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($dataPeriode as $item)
                                                        <a class="dropdown-item" href="{{ url('data_pemanfaatan?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kepala Rumah Tangga</th>
                                            <th>Kategori Pemanfaatan</th>
                                            <th>Periode</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($pemanfaatan as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        {{-- nama desa yang login --}}
                                        <td style="vertical-align: middle;">
                                            {{ucfirst($c->nama_kepala_rumah_tangga) }}

                                            @if (!$c->is_valid_pemanfaatan_lahan)
                                            <button class="btn btn-success btn-sm">
                                                edit untuk validasi
                                            </button>
                                        @endif
                                        </td>
                                        {{-- <td style="vertical-align: middle;">{{ucfirst($c->keluarga->nama_kepala_rumah_tangga) }}</td> --}}
                                        {{-- @if ($c->nama_kategori == 1)
                                            <td style="vertical-align: middle;">Peternakan</td>
                                        @elseif($c->nama_kategori == 2)
                                            <td style="vertical-align: middle;">Perikanan</td>
                                        @elseif($c->nama_kategori == 3)
                                            <td style="vertical-align: middle;">Warung Hidup</td>
                                        @elseif($c->nama_kategori == 4)
                                            <td style="vertical-align: middle;">TOGA (Tanaman Obat Keluarga)</td>
                                        @elseif($c->nama_kategori == 5)
                                            <td style="vertical-align: middle;">Tanaman Keras</td>
                                        @elseif($c->nama_kategori == 6)
                                            <td style="vertical-align: middle;">Lainnya</td>

                                        @endif --}}
                                        <td style="vertical-align: middle;">
                                            <ul >
                                                @foreach ($c->pemanfaatanlahan as $item)
                                                    <li>
                                                     {{ $item->pemanfaatan->nama_kategori}}

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td style="vertical-align: middle;">{{ucfirst($c->periode)}}</td>
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                            <div class="d-flex">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_pemanfaatan/'.$c->id.'/edit') }}">Edit</a>
                                                <form action="{{ route('data_pemanfaatan.deleted_all',[ 'id' => $c->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete ml-1">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

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
