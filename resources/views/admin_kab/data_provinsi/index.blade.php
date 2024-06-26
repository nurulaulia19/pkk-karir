@extends('admin_kab.layout')

@section('title', 'Data Provinsi | Super Admin PKK Kab. Indramayu')

@section('bread', 'Data Provinsi')
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
                                    {{-- <a href="{{ url('data_provinsi/create') }}" type="button" class="btn btn-success">Tambah</a><br><br> --}}
                                    @if(count($provinsi) < 1)
                                        <a href="{{ url('data_provinsi/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                    @endif
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Kode Provinsi</th>
                                        <th>Nama Provinsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($provinsi as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->kode_provinsi}}</td>
                                        <td style="vertical-align: middle;">{{$c->name}}</td>
                                        <td class="text-center">
                                            <form action="{{ route('data_provinsi.destroy',$c->id) }}" method="POST">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_provinsi/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                {{-- @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete" >Delete</button> --}}
                                            </form>
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
