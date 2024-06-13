@extends('admin_desa.layout')

@section('title', 'Data Kelompok PKK Dusun  | Admin Desa/Kelurahan PKK Kab. Indramayu')

@section('bread', 'Data Kelompok PKK Dusun ')
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
                                        <th>Dusun</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($dusun as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{ucfirst($c->name)}}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #50A3B9; color:white">
                                                    Rekap
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($periode as $item)
                                                    <a class="dropdown-item" href="{{ route('dusun.rekap', ['id' => $c->id]) }}?periode={{ $item->tahun }}">{{ $item->tahun }}</a>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </td>

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



@endpush
