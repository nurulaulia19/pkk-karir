@extends('admin_kab.layout')

@section('title', 'Kategori Pemanfaatan Tanah Pekarangan | Admin PKK Kab. Indramayu')

@section('bread', 'Kategori Pemanfaatan Tanah Pekarangan')
@section('container')

    <!-- Main content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" style="overflow: hidden">
                                <table class="table table-striped table-bordered data" id="add-row" width="82vw">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-md-1">
                                            <a href="{{ url('data_kategori_pemanfaatan_lahan/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemanfaatan as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;"> {{$c->nama_kategori}} </td>
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                            <div class="d-flex" style="justify-content: center">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_kategori_pemanfaatan_lahan/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('data_kategori_pemanfaatan_lahan.destroy', ['data_kategori_pemanfaatan_lahan' => $c->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete ml-1"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                          </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- {{ $pemanfaatan->links() }} --}}
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
    $('.data').DataTable({
        scrollX: true,
        "order": []
    });
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
