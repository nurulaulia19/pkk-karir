@extends('admin_desa.layout')

@section('title', 'Data RT | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Data RT')
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
                                    <div class="row">
                                    </div>
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama RT</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($rt->rt as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->name}}</td>
                                        {{-- <td class="text-center">
                                            <a class="btn btn-success btn-sm" href="{{ url('rekap_kelompok_pkk_rt').'?'.http_build_query([
                                                'rt' => $c->rt,
                                                'rw' => $c->rw,
                                                'periode' => $c->periode,
                                                ]) }}">Rekap
                                            </a>
                                        </td> --}}

                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm" href="{{ url('rekap_kelompok_pkk_rt', ['id' => $c->id]) }}">Rekap</a>
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
