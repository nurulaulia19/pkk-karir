@extends('admin_kab.layout')

@section('title', 'Data Agenda Kegiatan | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Data Agenda Kegiatan')
@section('container')

    <!-- Main content -->
    <div class="main-content">
    <section class="section">
        {{-- <h1 class="section-header">
            <div>Kandidat</div>
        </h1> --}}

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" style="overflow: hidden">
                                <table id="example1" class="table table-bordered table-striped" width="83vw">
                                    <a href="{{ url('agendaKeg/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>

                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Judul Agenda</th>
                                        <th>Tema Agenda</th>
                                        <th>Tempat</th>
                                        <th>Tanggal Publish Agenda</th>
                                        <th>Pukul</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($agenda as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->judul_agenda}}</td>
                                        <td style="vertical-align: middle;">{{$c->tema}}</td>
                                        <td style="vertical-align: middle;">{{$c->tempat}}</td>
                                        <td style="vertical-align: middle;">{{\Carbon\Carbon::parse($c->tgl_publish)->isoFormat('D MMMM Y')}}</td>
                                        <td style="vertical-align: middle;">{{$c->waktu}}</td>
                                        @if ($c->status == 1)
                                            <td style="vertical-align: middle;"><button class="btn btn-danger">Belum Terlaksana</button></td>
                                        @elseif($c->status ==2)
                                            <td style="vertical-align: middle;"><button class="btn btn-success">Sedang Terlaksana</button></td>
                                        @else
                                            <td style="vertical-align: middle;"><button class="btn btn-primary">Sudah Terlaksana</button></td>

                                        @endif

                                        <td style="vertical-align: middle;" class="text-center">
                                            <form action="{{ route('agendaKeg.destroy',$c->id) }}" method="POST">
                                                <a class="btn btn-primary btn-sm" href="{{ url('agendaKeg/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete mt-2 mt-sm-0" ><i class="fas fa-trash"></i></button>
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
  $(function () {
    $("#example1").DataTable({
        scrollX: true,
        "order": []
    });
  });
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
