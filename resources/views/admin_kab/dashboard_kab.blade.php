@extends('admin_kab.layout', [
    'newPeriode' => $newPeriode,
])

@section('title', 'Dashboard | Admin Kabupaten')
@section('bread', 'Dashboard')

@section('container')

    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($newPeriode)
                    <a class="btn btn-warning m-2" href="{{ route('admin_kabupaten.migrate') }}">Migrate data ke tahun
                        sekarang {{ $currentYear }}</a>
                @endif
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $berita }}</h3>
                            <p>Data Berita</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        <a href="/beritaKab" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $desa }}</h3>
                            <p>Data Desa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <a href="/data_desa" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #8576FF">
                        <div class="inner text-white">
                            <h3>{{ $kecamatan }}</h3>
                            <p>Data Kecamatan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-map"></i>
                        </div>
                        <a href="/data_kecamatan" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $agenda }}</h3>
                            <p>Data Agenda Kegiatan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-calendar"></i>
                        </div>
                        <a href="agendaKeg" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $galeri }}</h3>
                            <p>Data Galeri Kegiatan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-images"></i>
                        </div>
                        <a href="galeriKeg" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color:#FCDC2A">
                        <div class="inner text-white">
                            <h3>{{$pengguna}}</h3>
                            <p>Data Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="/data_pengguna_super" class="small-box-footer color-white">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $pemanfaatan }}</h3>
                            <p>Kategori Pemanfaatan Tanah Pekarangan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <a href="/data_kategori_pemanfaatan_lahan" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-white" style="background-color: #D10363">
                        <div class="inner">
                            <h3>{{ $industri }}</h3>
                            <p>Kategori Industri Rumah Tangga</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <a href="/data_kategori_industri" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p>Rekapitulasi Catatan dan <br>
                                Kegiatan Warga Kelompok <br> TP PKK Kecamatan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                            {{-- <div class="notification-badge">3</div> --}}
                        </div>
                        <a href="/data_kelompok_pkk_kec" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-white" style="background-color:#87A922">
                        <div class="inner">
                            <p>Rekapitulasi Catatan dan <br>
                                Kegiatan Warga Kelompok <br> TP PKK Kabupaten</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        <a href="/data_kelompok_pkk_kab" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content-wrapper -->

@endsection
