@extends('kader.layout')

@section('title', 'Data Industri Rumah Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Industri Rumah Warga')
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
                                            <a href="{{ url('data_industri/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                        </div>
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pilihan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ url('data_industri?periode=2024') }}">2024</a>
                                                    <a class="dropdown-item" href="{{ url('data_industri?periode=2025') }}">2025</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Keluarga</th>
                                            <th>Kategori</th>
                                            {{-- <th>Komoditi</th>
                                            <th>Volume</th> --}}
                                            <th>Periode</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($industri as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        {{-- nama desa yang login --}}
                                        <td style="vertical-align: middle;">{{ucfirst($c->nama_kepala_keluarga) }}</td>
                                        <td style="vertical-align: middle;">
                                            @if ($c->industri)
                                            {{ucfirst($c->industri->nama_kategori)}}
                                            @endif
                                        </td>
                                        {{-- <td style="vertical-align: middle;">{{ucfirst($c->komoditi)}}</td>
                                        <td style="vertical-align: middle;">{{ucfirst($c->volume)}}</td> --}}
                                        <td style="vertical-align: middle;">{{ucfirst($c->periode)}}</td>
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                            {{-- @if(date('Y') <= $c->periode) --}}
                                            <div class="d-flex">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_industri/'.$c->id.'/edit') }}">Edit</a>
                                                <form action="{{ route('data_industri.destroy',[ 'id' => $c->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete ml-1">Hapus</button>
                                                  </form>
                                            </div>
                                            {{-- @endif --}}
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
