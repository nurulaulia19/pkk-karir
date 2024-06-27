@extends('kader.layout')

@section('title', 'Dashboard | Kader Dasawisma PKK Kab. Indramayu')
@section('bread', 'Dashboard')

@section('container')


    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $warga }}</h3>
                            <p>Data Warga</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        @if ($wargaBelumValid > 0)
                            <div class="notification-badge">
                                {{ $wargaBelumValid }}
                            </div>
                        @endif
                        <a href="/data_warga" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $keluarga }}</h3>
                            <p>Data Keluarga</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        @if ($keluargaBelumValid > 0)
                            <div class="notification-badge">
                                {{ $keluargaBelumValid }}
                            </div>
                        @endif
                        <a href="/data_keluarga" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $krt }}</h3>
                            <div style="height: 50px">
                                <p>Data Rumah Tangga</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        @if ($krtBelumValid > 0)
                            <div class="notification-badge">
                                {{ $krtBelumValid }}
                            </div>
                        @endif
                        <a href="/data_rumah_tangga" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalKegiatan }}</h3>
                            <div style="50px">
                                <p>Data Kegiatan Warga</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        @if ($totalKegiatanBelumValid > 0)
                            <div class="notification-badge">
                                {{ $totalKegiatanBelumValid }}
                            </div>
                        @endif
                        <a href="/data_kegiatan" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $pemanfaatan }}</h3>
                            <div style="height:50px">
                                <p>Data Pemanfaatan Tanah Pekarangan</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-folder"></i>
                        </div>
                        @if ($pemanfaatanBelumValid > 0)
                            <div class="notification-badge">
                                {{ $pemanfaatanBelumValid }}
                            </div>
                        @endif
                        <a href="/data_pemanfaatan" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $industri }}</h3>
                            <div style="height: 50px">
                                <p>Data Industri Rumah Tangga</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        @if ($industriBelumValid > 0)
                            <div class="notification-badge">
                                {{ $industriBelumValid }}
                            </div>
                        @endif
                        <a href="/data_industri" class="small-box-footer">Lihat Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $rekap }}</h3>
                            <div style="height: 50px">
                                <p>Data Rekapitulasi Warga dan Catatan Keluarga</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-filing"></i>
                        </div>
                        @if ($rekapBelumValid > 0)
                            <div class="notification-badge">
                                {{ $rekapBelumValid }}
                            </div>
                        @endif
                        <a href="/catatan_keluarga" class="small-box-footer">Lihat Selengkapnya
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
