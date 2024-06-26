@extends('kader.layout')

@section('title' , 'Dashboard | Kader Dasawisma PKK Kab. Indramayu')
@section('bread' , 'Dashboard')

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
                        @if ($wargaBelumValid > 0)
                        <div class="notification-badge">
                            {{ $wargaBelumValid}}
                        </div>
                        @endif

                    </div>
                    <a href="/data_warga" class="small-box-footer"
                        >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                    ></a>
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
                    @if ($keluargaBelumValid > 0)
                        <div class="notification-badge">
                            {{ $keluargaBelumValid}}
                        </div>
                        @endif
                </div>
                <a href="/data_keluarga" class="small-box-footer"
                    >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                ></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $krt }}</h3>
                    <p>Data Rumah Tangga</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                    @if ($krtBelumValid > 0)
                        <div class="notification-badge">
                            {{ $krtBelumValid}}
                        </div>
                        @endif
                </div>
                <a href="/data_rumah_tangga" class="small-box-footer"
                    >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                ></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalKegiatan }}</h3>
                    <p>Data Kegiatan Warga</p>
                </div>
                <div class="icon">
                    <i class="ion ion-folder"></i>
                    @if ($totalKegiatanBelumValid > 0)
                        <div class="notification-badge">
                            {{ $totalKegiatanBelumValid}}
                        </div>
                        @endif
                </div>
                <a href="/data_kegiatan" class="small-box-footer"
                    >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                ></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $pemanfaatan }}</h3>
                    <p>Data Pemanfaatan Tanah Pekarangan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-folder"></i>
                        @if ($pemanfaatanBelumValid > 0)
                        <div class="notification-badge">
                            {{ $pemanfaatanBelumValid}}
                        </div>
                        @endif

                  </div>
                  <a href="/data_pemanfaatan" class="small-box-footer"
                    >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                  ></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $industri }}</h3>
                    <p>Data Industri Rumah Tangga</p>
                </div>
                <div class="icon">
                    <i class="ion ion-home"></i>
                    <div class="inner">
                        @if ($industriBelumValid > 0)
                        <div class="notification-badge">
                            {{ $industriBelumValid}}
                        </div>
                        @endif
                    </div>
                </div>
                <a href="/data_industri" class="small-box-footer"
                    >Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i
                ></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
                    <h3>{{ $rekap }}</h3>

                    <p>Data Rekapitulasi Warga dan Catatan Keluarga</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-filing"></i>
                    @if ($rekapBelumValid > 0)
                        <div class="notification-badge">
                            {{ $rekapBelumValid}}
                        </div>
                        @endif
                  </div>
                  <a href="/catatan_keluarga" class="small-box-footer">Lihat Selengkapnya
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
              </div>
        </div>
      </div>
    </section>

  @endsection
