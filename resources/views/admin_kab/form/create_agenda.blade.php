@extends('admin_kab.layout')

@section('title', 'Tambah Data Agenda Kegiatan | Admin Kabupaten PKK Kab. Indramayu')

@section('bread', 'Tambah Data Agenda Kegiatan')
@section('container')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header" style="background-color: #50A3B9; color:white">
        <h3 class="card-title">Tambah Data Agenda Kegiatan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <form action="{{ route('agendaKeg.store') }}" method="POST">
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
                    <input type="text" class="form-control @error('judul_agenda') is-invalid @enderror" name="judul_agenda" id="judul_agenda" placeholder="Masukkan Judul Agenda" value="{{old('judul_agenda')}}" required>
                    @error('judul_agenda')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    {{-- nama tema agenda --}}
                    <label>Tema</label>
                        <input type="text" class="form-control @error('tema') is-invalid @enderror" name="tema" id="tema" placeholder="Masukkan Tema" value="{{old('tema')}}" required>
                            @error('tema')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>

                <div class="form-group">
                    {{-- nama tempat --}}
                    <label>Tempat</label>
                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" id="tempat" placeholder="Masukkan Tempat" value="{{old('tempat')}}" required>
                            @error('tempat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>

                <div class="form-group">
                    {{-- nama pukul --}}
                    <label>Pukul</label>
                        <input type="time" class="form-control @error('waktu') is-invalid @enderror" name="waktu" id="waktu" placeholder="Diisi dengan waktu Agenda" value="{{old('waktu')}}" required>
                            @error('waktu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal </label>
                    <input type="date" class="form-control" name="tgl_pelaksana" id="tgl_pelaksana" placeholder="Masukkan Tanggal Berita" required value="{{old('tgl_pelaksana')}}">
                    @error('tgl_pelaksana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label>Status</label><br>
                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                        <option selected disabled>Pilih Status</option>
                        <option value="1">Belum Terlaksana</option>
                        <option value="2">Sedang Terlaksana</option>
                        <option value="3">Sudah Terlaksana</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label>Status</label><br>
                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                        <option disabled>Pilih Status</option>
                        <option value="1" @if(old('status') == '1') selected @endif>Belum Terlaksana</option>
                        <option value="2" @if(old('status') == '2') selected @endif>Sedang Terlaksana</option>
                        <option value="3" @if(old('status') == '3') selected @endif>Sudah Terlaksana</option>
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
          <button type="submit" class="btn" style="background-color: #50A3B9; color:white">Tambah</button>
          <a href="/agendaKeg" class="btn btn-outline-danger">
            <span>Batalkan</span>
        </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
@endsection

