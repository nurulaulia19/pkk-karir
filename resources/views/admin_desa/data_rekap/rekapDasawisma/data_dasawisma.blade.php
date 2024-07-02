@extends('admin_desa.layout')

@section('title', 'Data Dasawisma | Admin Desa PKK Kab. Indramayu')

@section('bread', 'Data Dasawisma')
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
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Dasawisma</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($dasawisma as $c)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                    <td style="vertical-align: middle;">{{ ucfirst($c->nama_dasawisma) }}</td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="dropdown">
                                                                <button class="btn dropdown-toggle" type="button"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    style="background-color: #50A3B9; color:white">
                                                                    Rekap
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    @foreach ($periode as $item)
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('rekap_kelompok_dasa_wisma', ['id' => $c->id]) }}?periode={{ $item->tahun }}">{{ $item->tahun }}</a>
                                                                    @endforeach
                                                                </div>
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
        $(document).ready(function() {
            $('.data').DataTable();
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
