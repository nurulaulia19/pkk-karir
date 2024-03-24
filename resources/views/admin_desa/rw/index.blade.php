@extends('admin_desa.layout')

@section('title', 'Data RW | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Data RW')
@section('container')

    <!-- Main content -->
<div class="main-content">
    <section class="section">
        {{-- <h1 class="section-header">
            <div>Kandidat</div>
        </h1> --}}

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data" id="add-row">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <a href="{{ url('rw/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama Rw</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($rw as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->name}}</td>
                                        <td class="text-center">
                                            <div class="row justify-content-center">
                                                <div class="col-md-2">
                                                    <a class="btn btn-warning btn-sm btn-block" href="{{ url('rw/'.$c->id) }}">Data RT</a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn btn-primary btn-sm btn-block" href="{{ url('rw/'.$c->id.'/edit') }}">Edit</a>
                                                </div>
                                                <div class="col-md-2">
                                                    <form action="{{ route('rw.destroy', $c->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-block delete">Delete</button>
                                                    </form>
                                                </div>
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
