@extends('admin_desa.layout')

@section('title', 'Data RT | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Data RT')
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
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="{{ route('rt.create', ['rw' => $rt->id]) }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah RT</a><br><br>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama RT</th>
                                        <th>RW</th>
                                        <th>Dusun</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($rt->rt as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->name}}</td>
                                        <td style="vertical-align: middle;">
                                            @if ($c->rw)
                                                {{ $c->rw->name }}
                                            @else
                                                Tidak ada RW
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if ($c->dusun)
                                                {{ $c->dusun->name }}
                                            @else
                                                Tidak memiliki dusun
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a class="btn btn-primary btn-sm ml-1" href="{{ url('rt/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('rt.destroy',$c->id) }}" method="POST">
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
