@extends('admin_kab.layout')

@section('title', 'Kategori Industri Rumah Tangga | Admin PKK Kab. Indramayu')

@section('bread', 'Kategori Industri Rumah Tangga')
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
                                            <a href="{{ url('data_kategori_industri/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
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
                                        @foreach ($industri as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;"> {{$c->nama_kategori}} </td>
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                            <div class="d-flex">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_kategori_industri/'.$c->id.'/edit') }}">Edit</a>
                                                <form action="{{ route('data_kategori_industri.destroy', ['data_kategori_industri' => $c->id]) }}" method="POST">
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
                            {{-- {{ $industri->links() }} --}}
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
