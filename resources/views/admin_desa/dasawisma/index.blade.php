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
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-md-1">
                                            <a href="{{ url('data_dasawisma/create') }}" type="button" class="btn" style="background-color: #50A3B9; color:white">Tambah</a><br><br>
                                        </div>
                                        {{-- <div class="col-md-1" style="margin-bottom: 20px;">
                                            <div class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #50A3B9; color:white">
                                                        Pilih
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach ($periodes as $item)
                                                        <a class="dropdown-item" href="{{ url('data_dasawisma') }}?periode={{ $item->tahun }}">{{ $item->tahun }}</a>
                                                        @endforeach
                                                    </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-1" style="margin-bottom: 20px;">
                                            <div class="dropdown ml-auto" style="max-width: fit-content;">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #50A3B9; color:white">
                                                    Pilih
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="max-width: 200px;">
                                                    @foreach ($periodes as $item)
                                                    <a class="dropdown-item text-truncate" href="{{ url('data_dasawisma') }}?periode={{ $item->tahun }}">{{ $item->tahun }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama Dasawisma</th>
                                        <th>Alamat Dasawisma</th>
                                        <th>RT/RW</th>
                                        <th>Dusun</th>
                                        <th>Status</th>
                                        <th>Nama Desa</th>
                                        {{-- <th>Nama Kecamatan</th> --}}
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($dasawisma as $c)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{$c->nama_dasawisma}}</td>
                                        <td style="vertical-align: middle;">{{$c->alamat_dasawisma}}</td>
                                        {{-- <td style="vertical-align: middle;">{{$c->rt}}/{{ $c->rw }}</td> --}}
                                        <td style="vertical-align: middle;">
                                            {{-- {{ $c->rt->name }}/{{ $c->rw->name }} --}}
                                            @if ($c->rt && $c->rt->name)
                                                {{ $c->rt->name }}
                                            @else
                                                -
                                            @endif
                                            /
                                            @if ($c->rw && $c->rw->name)
                                                {{ $c->rw->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{-- {{$c->dusun->name}} --}}
                                            @if($c->dusun == 0)
                                                Tidak ada dusun
                                            @else
                                                {{$c->dusunData->name}}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @if($c->status == 1)
                                                Aktif
                                            @else
                                                Tidak Aktif
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle;">{{$c->desa->nama_desa}}</td>
                                        {{-- <td style="vertical-align: middle;">{{$c->kecamatan->nama_kecamatan}}</td> --}}
                                        <td style="vertical-align: middle;">{{$c->periode}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-primary btn-sm" href="{{ url('data_dasawisma/'.$c->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('data_dasawisma.destroy',$c->id) }}" method="POST">
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
