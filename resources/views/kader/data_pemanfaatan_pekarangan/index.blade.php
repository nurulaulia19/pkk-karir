@extends('kader.layout')

@section('title', 'Data Pemanfaatan Tanah Pekarangan | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Pemanfaatan Tanah Pekarangan ')
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
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-md-1">
                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                    <a href="{{ url('data_pemanfaatan/create') }}" type="button"
                                                        class="btn"
                                                        style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"
                                                            style="background-color: #6e9ebb; color:white">
                                                            Pilihan
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($dataPeriode as $item)
                                                                <a class="dropdown-item"
                                                                    href="{{ url('data_pemanfaatan?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kepala Rumah Tangga</th>
                                                <th>Kategori Pemanfaatan</th>
                                                <th>Periode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($pemanfaatan as $c)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ ucfirst($c->nama_kepala_rumah_tangga) }} <br>
                                                        @if (!$c->is_valid_pemanfaatan_lahan)
                                                            <a href="{{ url('data_pemanfaatan/' . $c->id . '/edit') }}"
                                                                class="btn btn-sm"
                                                                style="background-color: #50A3B9; color:white">
                                                                Edit untuk validasi
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <ul>
                                                            @foreach ($c->pemanfaatanlahan as $item)
                                                                <li>
                                                                    {{ $item->pemanfaatan->nama_kategori }}

                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->periode) }}</td>
                                                        <td class="text-center" style="vertical-align: middle;">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                                <a class="btn btn-primary btn-sm"
                                                                    href="{{ url('data_pemanfaatan/' . $c->id . '/edit') }}"><i class="fas fa-edit"></i>
                                                                </a>
                                                                @endif
                                                                <form
                                                                    action="{{ route('data_pemanfaatan.deleted_all', ['id' => $c->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete ml-1"><i class="fas fa-trash"></i></button>
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
        $(document).ready(function() {
            $('.data').DataTable({
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
