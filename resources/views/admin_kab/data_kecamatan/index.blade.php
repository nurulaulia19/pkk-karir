@extends('admin_kab.layout')

@section('title', 'Data Kecamatan | Super Admin PKK Kab. Indramayu')

@section('bread', 'Data Kecamatan')
@section('container')

    <!-- Main content -->
    <div class="main-content">
    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data" id="add-row">
                                    <a href="{{ url('data_kecamatan/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Kode Kecamatan</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Nama Kabupaten</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($kecamatan as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->kode_kecamatan}}</td>
                                        <td style="vertical-align: middle;">{{$c->nama_kecamatan}}</td>
                                        <td style="vertical-align: middle;">{{$c->kabupaten->name}}</td>
                                        <td class="text-center">
                                            <form action="{{ route('data_kecamatan.destroy',$c->id) }}" method="POST">

                                            {{-- <a class="btn btn-info btn-sm" href="{{ route('sisw.show',$siswa->id) }}">Show</a> --}}

                                                <a class="btn btn-primary btn-sm" href="{{ url('data_kecamatan/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete" ><i class="fas fa-trash"></i></button>
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
