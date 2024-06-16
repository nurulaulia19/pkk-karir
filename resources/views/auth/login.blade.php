@extends('layouts.app')
@section('content')
    <section class="vh-100">
        <div class="container-fluid" style="background-color: #6B8DB2 ;">
            <div class="row">
                <div class="col-sm-12 col-md-6 text-black d-flex justify-content-center align-items-center vh-100">
                    <div class="col-md-8"
                        style="background-color: #ffffff; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                        <div style="margin-top: 70px; display:flex; justify-content:center">
                            <img src="{{ url('image/remove.png') }}" width="100px" class="img-fluid">
                        </div>
                        <div
                            class="d-flex justify-content-center align-items-center h-custom-2 ms-xl-4 pt-xl-0 mt-xl-n5 col-12">
                            <form class="col-sm-12 col-md-8" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h3 class="fw-normal mb-5 pb-3" style="letter-spacing: 6px;"></h3>
                                <p style="font-size: 30px; font-weight:500; font-family:Arial, Helvetica, sans-serif">Log In
                                </p>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <label for="email">Email</label>
                                    <input placeholder="Masukkan Email..." id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <label class="form-label" for="form2Example18">Email address</label>
                                    <input type="email" id="form2Example18" class="form-control form-control-lg" /> --}}
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4 password-container">
                                    <label for="password">Password</label>
                                    <input placeholder="Masukkan Password..." id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="current-password">
                                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <label class="form-label" for="form2Example28">Password</label>
                                    <input type="password" id="form2Example28" class="form-control form-control-lg" /> --}}
                                </div>

                                <div class="pt-1" style="margin-bottom: 100px">
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block"
                                        type="submit">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 px-0 d-none d-md-flex justify-content-center align-items-center bg-white">
                    <div>
                        <img src="{{ asset('assets/img/login.svg') }}" alt="Login image" width="400px"
                            style="object-fit: cover; object-position: left;">
                        <div style="margin-left:15px; margin-top:15px; font-weight:bold; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; font-size:30px; color: #50A3B9; line-height:15px">
                            <p>Halo Semua</p>
                            <p>Selamat Datang Kembali !</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
