@extends('admin_kab.layout')

@section('title', 'Profil Pembina dan Ketua TP PKK Kab. Indramayu | Admin PKK Kab. Indramayu' )

@section('bread', 'Profil Pembina dan Ketua Admin Kabupaten')

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
                                    <table class="table table-striped table-bordered data" id="add-row" width="83vw">
                                    <a href="{{ url('profile-pembina-ketua/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Masa Jabatan</th>
                                                <th>Jabatan</th>
                                                <th>Riwayat Pendidikan</th>
                                                <th>Riwayat Pekerjaan</th>
                                                <th>Foto</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profiles as $profile)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                    <td style="vertical-align: middle;">{{ $profile->nama_lengkap }}</td>
                                                    <td style="vertical-align: middle;">{{ $profile->tempat_lahir }} , {{ $profile->tanggal_lahir }}</td>
                                                    <td style="vertical-align: middle;">{{ $profile->masa_jabatan_mulai }} - {{ $profile->masa_jabatan_akhir }}</td>
                                                    <td style="vertical-align: middle;">{{ $profile->jabatan }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{-- {{ $profile->riwayat_pendidikan }} --}}
                                                        <ul>
                                                        @foreach (explode(', ', $profile->riwayat_pendidikan) as $index => $pekerjaan)
                                                                <li>{{ $pekerjaan }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{-- {{ $profile->riwayat_pekerjaan }} --}}
                                                        @if($profile->riwayat_pekerjaan)
                                                        <ul>
                                                            @foreach (explode(', ', $profile->riwayat_pekerjaan) as $index => $pekerjaan)
                                                                <li>{{ $pekerjaan }}</li>
                                                            @endforeach
                                                        </ul>
                                                        @endif

                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($profile->foto)
                                                        <img
                                                            src="{{ $profile->foto ? asset('uploads/' . $profile->foto) : asset('assets/img/profile.png') }}"
                                                            width="30px">
                                                        @else
                                                            Belum ada foto
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;" class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <a class="btn btn-primary btn-sm"
                                                                href="{{ route('profile-pembina-ketua.edit', $profile->id) }}"><i
                                                                    class="fas fa-edit"></i></a>
                                                            <form action="{{ route('profile-pembina-ketua.destroy', $profile->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm delete ml-1"><i
                                                                        class="fas fa-trash"></i></button>
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
@endsection
@push('script-addon')
<script>
    $(function () {
      $(".data").DataTable({
        scrollX: true,
        "order": []
      });
    });
  </script>
<script>
    $('.delete').click(function(event) {
        var form = $(this).closest("form");
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

