@extends('admin_kab.layout')

@section('title', 'Data Pengguna TP PKK | Super Admin PKK Kab. Indramayu')

@section('bread', 'Data Pengguna TP PKK')
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
                                    <a href="{{ url('data_pengguna_super/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>

                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Foto</th>
                                        <th>Nama Desa</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($users as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->name}}</td>
                                        <td style="vertical-align: middle;">{{$c->email}}</td>
                                        <td style="vertical-align: middle;">{{$c->user_type}}</td>
                                        {{-- <td style="vertical-align: middle;"><img src="{{$c->foto ? Storage::disk('public')->url($c->foto) : null}}" width="100px"></td> --}}
                                        <td style="vertical-align: middle; text-align: center;"><img
                                            src="{{ $c->foto ? asset('uploads/' . $c->foto) : asset('assets/img/profile.png') }}"
                                            {{-- src="{{ asset('uploads/'.$c->foto) }}" --}}
                                            width="30px"></td>
                                        <td style="vertical-align: middle;">
                                            @if ($desa = $c->desa)
                                                {{ $desa->nama_desa }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td style="vertical-align: middle;">
                                            @if ($kecamatan = $c->kecamatan)
                                            {{ $kecamatan->nama_kecamatan }}
                                        @else
                                            -
                                        @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_pengguna_super/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('data_pengguna_super.destroy',$c->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete ml-1" ><i class="fas fa-trash"></i></button>
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
