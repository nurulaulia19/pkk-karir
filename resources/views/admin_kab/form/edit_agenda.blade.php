@extends('admin_desa.layout')

@section('title', 'Edit Data Agenda Kegiatan | Admin Kabupaten PKK Kab. Indramayu')

@section('bread', 'Edit Data Agenda Kegiatan')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Agenda Kegiatan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ url ('/agendaKeg', $agendaKeg->id) }}" method="POST">
      @method('PUT')
        @csrf
        @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{  ($error)  }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <div class="form-group">
                <label>Judul Agenda</label>
                <input type="text" class="form-control @error('judul_agenda') is-invalid @enderror" name="judul_agenda" id="judul_agenda" placeholder="Masukkan Judul Agenda" value="{{$agendaKeg->judul_agenda}}">
                    @error('judul_agenda')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="form-group">
                {{-- nama tema agenda --}}
                <label>Tema</label>
                    <input type="text" class="form-control @error('tema') is-invalid @enderror" name="tema" id="tema" placeholder="Masukkan Tema" value="{{$agendaKeg->tema}}">
                        @error('tema')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>

            <div class="form-group">
                {{-- nama tempat --}}
                <label>Tempat</label>
                    <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" id="tempat" placeholder="Masukkan Tempat" value="{{$agendaKeg->tempat}}">
                        @error('tempat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>

            <div class="form-group">
                {{-- nama pukul --}}
                <label>Pukul</label>
                    <input type="text" class="form-control @error('waktu') is-invalid @enderror" name="waktu" id="waktu" placeholder="Diisi dengan waktu Agenda" value="{{$agendaKeg->waktu}}">
                        @error('waktu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control @error('tgl_pelaksana') is-invalid @enderror" name="tgl_pelaksana" id="tgl_pelaksana" placeholder="Masukkan Tanggal Berita" required value="{{$agendaKeg->tgl_pelaksana}}">
                @error('tgl_pelaksana')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label><br>
                <select class="form-control @error('status') is-invalid @enderror" name="status">
                    <option hidden>Pilih Status</option>
                    <option value="1" {{ $agendaKeg->status == '1' ? 'selected':'' }}>Belum Terlaksana</option>
                    <option value="2" {{ $agendaKeg->status == '2' ? 'selected':'' }}>Sedang Terlaksana</option>
                    <option value="3" {{ $agendaKeg->status == '3' ? 'selected':'' }}>Sudah Terlaksana</option>
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Edit</button>
          <a href="/agendaKeg" class="btn btn-outline-primary">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

