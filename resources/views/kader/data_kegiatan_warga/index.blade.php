@extends('kader.layout')

@section('title', 'Data Kegiatan Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Kegiatan Warga')
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
                                            @if ($nowYear == $periode)
                                            <a href="{{ url('data_kegiatan/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pilihan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($dataPeriode as $item)
                                                        <a class="dropdown-item" href="{{ url('data_kegiatan?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Warga</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Periode</th>
                                            @if ($nowYear == $periode)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($kegiatan as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{ $c->nama }}
                                            @if ($c->kegiatan->first() && !$c->kegiatan->first()->is_valid)
                                            <button class="btn btn-success btn-sm">
                                                Edit untuk validasi
                                            </button>
                                        @endif

                                        </td>
                                        <td style="vertical-align: middle;">
                                            <ul>
                                                @foreach ($c->kegiatan as $item)
                                                    <li>
                                                        {{ $item->kegiatan->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        {{-- <td style="vertical-align: middle;">x</td> --}}
                                        {{-- <td style="vertical-align: middle;">x</td> --}}
                                        <td style="vertical-align: middle;">{{ $c->periode }}</td>
                                        @if ($nowYear == $periode)
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                           <div class="d-flex">
                                            <a class="btn btn-primary btn-sm" href="{{ url('data_kegiatan/'.$c->id.'/edit') }}">Edit</a>
                                            <form action="{{ route('data_kegiatan.destroyed',[ 'id' => $c->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete ml-1">Hapus</button>
                                            </form>
                                           </div>
                                        </td>
                                        @endif
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
