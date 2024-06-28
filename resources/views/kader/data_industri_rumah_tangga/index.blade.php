@extends('kader.layout')

@section('title', 'Data Industri Rumah Warga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Industri Rumah Warga')
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
                                                    <a href="{{ url('data_industri/create') }}" type="button"
                                                        class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="background-color: #6e9ebb; color:white">
                                                            Pilihan
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($dataPeriode as $item)
                                                                <a class="dropdown-item"
                                                                    href="{{ url('data_industri?periode=' . $item->tahun) }}">{{ $item->tahun }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Keluarga</th>
                                                <th>Kategori</th>
                                                <th>Periode</th>
                                                @if ($nowYear == $periode && $user->dasawisma->status)
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($industri as $c)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ ucfirst($c->nama_kepala_keluarga) }} <br>
                                                        @if (!$c->is_valid_industri)
                                                            <a href="{{ url('data_industri/' . $c->id . '/edit') }}" class="btn btn-sm" style="background-color: #50A3B9; color:white">
                                                                Edit untuk validasi
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($c->industri)
                                                            {{ ucfirst($c->industri->nama_kategori) }}
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->periode) }}</td>
                                                    @if ($nowYear == $periode && $user->dasawisma->status)
                                                        <td class="text-center" width="100px"
                                                            style="vertical-align: middle;">
                                                            <div class="d-flex" style="justify-content: center">
                                                                <a class="btn btn-primary btn-sm"
                                                                    href="{{ url('data_industri/' . $c->id . '/edit') }}"><i class="fas fa-edit"></i></a>
                                                                <form
                                                                    action="{{ route('data_industri.destroy', ['id' => $c->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete ml-1"><i class="fas fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
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
