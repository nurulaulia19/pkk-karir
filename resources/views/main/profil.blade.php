@extends('main.layout')

@section('title', 'Profil Pembina dan Ketua PKK | PKK Kab. Indramayu')

@section('container')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    {{-- <h2>Profil Pembina dan Ketua TP PKK</h2> --}}
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Profil Pembina dan Ketua TP PKK</li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- End Breadcrumbs -->

        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                @foreach ($profiles as $item)
                <h1>{{ $item->jabatan }} TP PKK</h1>
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                {{-- <div class="swiper-slide"> --}}
                                <img
                                src="{{ $item->foto ? asset('uploads/' . $item->foto) : asset('assets/img/profile.png') }}"

                                height="800px" />
                                {{-- </div> --}}

                            </div>
                            {{-- <div class="swiper-pagination"></div> --}}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3>Biodata</h3>
                            <ul>
                                <li><strong>Nama Lengkap</strong>: {{ $item->nama_lengkap }}</li>
                                <li><strong>Tanggal lahir</strong>: {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</li>
                                <li><strong>Masa Jabatan periode</strong>: {{ $item->masa_jabatan_mulai }}-{{ $item->masa_jabatan_akhir }}</li>
                                <li>
                                    <strong>Riwayat Pendidikan</strong>:
                                    <ul>
                                        @foreach (explode(', ', $item->riwayat_pendidikan) as $index => $pendidikan)
                                            <li>{{ $pendidikan }}</li>

                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="portfolio-description">
                            @if ($item->riwayat_pekerjaan)
                            <strong>Riwayat Pekejaan</strong>:
                            <ul>
                                @foreach (explode(', ', $item->riwayat_pekerjaan) as $index => $pekerjaan)
                                            <li>{{ $pekerjaan }}</li>

                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <br><br>
                @endforeach

                {{-- <h1>Ketua TP PKK</h1>
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                <img src="/image/9.png" height="100%" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3>Biodata</h3>
                            <ul>
                                <li><strong>Nama Lengkap</strong>: Dr. Runisah, M.Pd.</li>
                                <li><strong>Tanggal lahir </strong>: Bandung, 28 Juli 1969</li>
                                <li><strong>Masa Jabatan periode</strong>: 2021-2026</li>
                                <li>
                                    <strong>Riwayat Pendidikan</strong>:
                                    <ul>
                                        <li>SD N Raya Barat VI Bandung tahun 1982</li>
                                        <li>SMP N 24 Bandung tahun 1985</li>
                                        <li>SMA N 4 Bandung tahun 1988</li>
                                        <li>S-1 Pendidikan Matematika IKIP Bandung tahun 1993</li>
                                        <li>S-2 Pendidikan Matematika UPI Bandung tahun 2006</li>
                                        <li>S-3 Pendidikan Matematika UPI Bandung tahun 2016</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
        <!-- End Portfolio Details Section -->
    </main>


@endsection
