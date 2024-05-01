@extends('kader.layout')

@section('title', 'Data Keluarga | Kader Dasawisma PKK Kab. Indramayu')

@section('bread', 'Data Keluarga')
@section('container')

    <!-- Main content -->
<div class="main-content">
    <section class="section">

        <div class="section-body">
            <div class="row w-full">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data" id="add-row">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <a href="{{ url('data_keluarga/create') }}" type="button" class="btn btn-success">Tambah</a><br><br>
                                        </div>
                                    </div>

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kepala Keluarga</th>
                                            <th>Jumlah Anggota Keluarga</th>
                                            <th>Jumlah Anggota Keluarga Laki-laki</th>
                                            <th>Jumlah Anggota Keluarga Perempuan</th>
                                            {{-- <th>Jumlah Kepala Keluarga (KK)</th>
                                            <th>Periode</th> --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($keluarga as $c)
                                    <tr>
                                        <td style="vertical-align: middle; position: relative;">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- nama desa yang login --}}
                                        <td style="vertical-align: middle;">
                                            {{ucfirst($c->nama_kepala_keluarga) }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{ ucfirst($c->anggota->count()) }} Orang
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{-- {{ ucfirst($c->anggota->warga->where('jenis_kelamin', 'laki-laki')->count()) }}
                                            Orang --}}
                                            @php
                                                $countLakiLaki = 0;
                                            @endphp
                                            @foreach ($c->anggota as $anggota)
                                                @if ($anggota->warga->jenis_kelamin === 'laki-laki')
                                                    @php
                                                        $countLakiLaki++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            {{ ucfirst($countLakiLaki) }} Orang
                                        </td>
                                        <td style="vertical-align: middle;">
                                            @php
                                                $countPerempuan = 0;
                                            @endphp
                                            @foreach ($c->anggota as $anggota)
                                                @if ($anggota->warga->jenis_kelamin === 'perempuan')
                                                    @php
                                                        $countPerempuan++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            {{ ucfirst($countPerempuan) }} Orang
                                        <td class="text-center" width="100px" style="vertical-align: middle;">
                                            <div class="d-flex">
                                                {{-- <a href="{{ route('keluarga-detail',['id' => $c->id]) }}" class="btn btn-warning btn-sm" >
                                                    Detail
                                                </a> --}}
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#details-modal-{{ $c->id }}">
                                                    Detail
                                                </button>
                                                <a class="btn btn-primary btn-sm ml-1" href="{{ route('data_keluarga.edit', $c->id) }}">Edit</a>
                                                <form action="{{ route('data_keluarga.destroy', $c->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete ml-1">Hapus</button>
                                                </form>
                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                                @foreach ($keluarga as $c)
                                <div id="details-modal-{{ $c->id }}" class="modal fade" tabindex="1" role="dialog" aria-labelledby="details-modal-{{ $c->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Details</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                                <div class="modal-body">
                                                    <h5>
                                                        Dasawisma :
                                                        <strong>
                                                            {{ucfirst($c->dasawisma->nama_dasawisma) }}
                                                        </strong>
                                                        <br>
                                                        RT / RW :
                                                        <strong>
                                                            {{ ($c->dasawisma->rt->name) }} / {{ ($c->dasawisma->rw->name) }}
                                                        </strong> <br>
                                                        {{-- Dusun :
                                                        <strong>
                                                            {{ ($c->dusun) }}
                                                        </strong>
                                                        <br> --}}
                                                        Desa/Kel :
                                                        <strong>
                                                            {{ucfirst($c->dasawisma->desa->nama_desa)}}
                                                        </strong>
                                                        <br>
                                                        Kec.
                                                        <strong>
                                                            {{ucfirst($c->dasawisma->desa->kecamatan->nama_kecamatan)}}
                                                        </strong>,
                                                        Kabupaten
                                                        <strong>
                                                            {{ucfirst($c->dasawisma->desa->kecamatan->kabupaten->name)}}
                                                        </strong>,
                                                        Provinsi
                                                        <strong>
                                                            {{ucfirst($c->dasawisma->desa->kecamatan->kabupaten->provinsi->name)}}
                                                        </strong>
                                                        <br>
                                                        Nama Kepala Keluarga :
                                                        <strong>
                                                            {{ucfirst($c->nama_kepala_keluarga) }}
                                                        </strong><br>
                                                        Jumlah Anggota Keluarga : <strong>
                                                            {{ucfirst($c->anggota->count()) }}
                                                        </strong>Orang<br>
                                                        Jumlah Balita :
                                                        <strong>
                                                            {{ $c->anggota->filter(function($anggota) {
                                                                // Calculate age based on birthdate
                                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                                $today = new DateTime();
                                                                $age = $today->diff($birthdate)->y;
                                                                return $age <= 5;
                                                            })->count() }}
                                                        </strong> Orang <br>
                                                        Jumlah WUS (Wanita Usia Subur)
                                                        <strong>
                                                            {{ $c->anggota->filter(function($anggota) {
                                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                                $today = new DateTime();
                                                                $age = $today->diff($birthdate)->y;
                                                                // Check if the member is female, aged between 15 and 49, and married
                                                                return $anggota->warga->jenis_kelamin === 'perempuan' && $age >= 15 && $age <= 49 && $anggota->warga->status_perkawinan === 'menikah';
                                                            })->count() }}
                                                        </strong> orang <br>
                                                        Jumlah PUS (Pasangan Usia Subur) :
                                                        <strong>
                                                            {{ $c->anggota->filter(function($anggota) {
                                                                // Calculate age based on birthdate
                                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                                $today = new DateTime();
                                                                $age = $today->diff($birthdate)->y;
                                                                // Check if the member is aged between 15 and 49 and married
                                                                return $age >= 15 && $age <= 49 && $anggota->warga->status_perkawinan === 'menikah';
                                                            })->count() }}
                                                        </strong> orang <br>
                                                        {{-- Jumlah 3 Buta (Buta Warna, Buta Baca, Buta Hitung):  2 orang<br> --}}
                                                        Jumlah Ibu Hamil :
                                                        <strong>
                                                            {{ ucfirst($c->anggota->filter(function($anggota) {
                                                                return $anggota->warga->ibu_hamil;
                                                            })->count()) }}
                                                        </strong> Orang <br>
                                                        Jumlah Ibu Menyusui :
                                                        <strong>
                                                            {{ ucfirst($c->anggota->filter(function($anggota) {
                                                                return $anggota->warga->ibu_menyusui;
                                                            })->count()) }}
                                                        </strong> Orang <br>
                                                        Jumlah  Lansia :
                                                        <strong>
                                                            {{ $c->anggota->filter(function($anggota) {
                                                                // Calculate age based on birthdate
                                                                $birthdate = new DateTime($anggota->warga->tgl_lahir);
                                                                $today = new DateTime();
                                                                $age = $today->diff($birthdate)->y;
                                                                return $age >= 45;
                                                            })->count() }}
                                                        <br>
                                                        </strong>
                                                        Jumlah Kebutuhan Khusus :
                                                        <strong>
                                                            {{ $c->anggota->filter(function($anggota) {
                                                                return $anggota->warga->berkebutuhan_khusus !== null && $anggota->warga->berkebutuhan_khusus !== 'Tidak';
                                                            })->count() }}
                                                        </strong> Orang <br>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Oke</button>
                                                        {{-- <button type="button" class="btn btn-primary">Oke</button> --}}
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


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
