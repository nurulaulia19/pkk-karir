@extends('main.layout')

@section('title', 'Agenda Kegiatan PKK | PKK Kab. Indramayu')

<style type="text/css">
    [aria-expanded="false"]>.expanded,
    [aria-expanded="true"]>.collapsed {
        display: none;
    }
    .card-body {
        display: flex;
        flex-wrap: wrap;
        margin: 20px 0;
    }

    .agenda-card {
        margin: 10px;
        flex: 0 0 calc(33.33% - 20px); /* Card width for desktop */
        max-width: calc(33.33% - 20px); /* Card max-width for desktop */
    }

    @media (max-width: 992px) {
        .agenda-card {
            flex: 0 0 calc(50% - 20px); /* Card width for tablets */
            max-width: calc(50% - 20px); /* Card max-width for tablets */
        }
    }

    @media (max-width: 576px) {
        .agenda-card {
            flex: 0 0 95%; /* Card width for mobile */
            max-width: 95%; /* Card max-width for mobile */
        }
    }
</style>
@section('container')
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- <h2>Inner Page</h2> -->
                <ol>
                    <li><a href="/">Home</a></li>
                    <li>Agenda Kegiatan PKK</li>
                </ol>
            </div>

            <br><br>
            <div class="content">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            Agenda Kegiatan
                        </div>
                        <div class="card-body" style="margin: 20px 0; display: flex; flex-wrap: wrap;">
                            @foreach ($agenda as $i)
                                <div class="agenda-card" style="margin: 10px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f9fa;">
                                    <h4 style="font-family: 'Times New Roman', Times, serif; margin-bottom: 10px;">{{ $i->judul_agenda }}</h4>
                                    <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">Tema : {{ $i->tema }}</p>
                                    <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">Tanggal : {{ \Carbon\Carbon::parse($i->tgl_pelaksana)->isoFormat('D MMMM Y') }}</p>
                                    <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">Waktu : {{ $i->waktu }}</p>
                                    @if ($i->status == 1)
                                        <button class="btn btn-primary">Belum Terlaksana</button>
                                    @elseif ($i->status == 2)
                                        <button class="btn btn-success">Sedang Terlaksana</button>
                                    @else
                                        <button class="btn btn-danger">Sudah Terlaksana</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div><!-- /.container-fluid -->
        </div>

    </section>

@endsection

@push('script-addon')
@endpush
