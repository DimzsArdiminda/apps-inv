@extends('layout.master2.master2')
@section('title', 'Login')

@section('content')
<!-- Outer Row -->
<!-- Contoh kode dari Flag Counter -->

<div class="row justify-content-center">

    <div class="col-xl-12 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Admin Login</h6>
            </div>
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        <img class="img-fluid" src="{{ asset('img/security 2.jpg') }}">
                    </div>
                    <div class="col-lg-6" style="align-content: center">
                        <div class="p-5">
                            <h1 class="display-3 text-primary mb-4 font-weight-bold">Login</h1>
                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-4 text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="user" method="POST" action="{{ route('login.act') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control form-control-user"
                                        id="email" aria-describedby="emailHelp"
                                        placeholder="Tulis Email Anda..." name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                    @error('email')
                                        <div class="mt-2 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input type="password" class="form-control form-control-user"
                                        id="password" placeholder="Password" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <div class="mt-2 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="showPassword" onclick="togglePassword()">
                                        <label class="custom-control-label" for="showPassword">Show Password</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('Log in') }}
                                </button>
                            </form>
                            <hr>
                            <div class="text-start">
                                  <a class="medium" href="{{ url('/reset-password') }}">Reset your password ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Show Password --}}
    <script src="{{ asset('js/password.js') }}"></script>
</div>    
@endsection
