@extends('layout.master2.master2')
@section('title', 'Reset Password')

@section('content')
<!-- Outer Row -->
<div class="col-xl-12 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reset Password</h6>
        </div>
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-password-image">
                    <img class="img-fluid" src="{{ asset('img/security 2.jpg') }}">
                </div>
                <div class="col-lg-6" style="align-content: center">
                    <div class="p-5">
                        <div class="text-start">
                            <h1 class="display-5 text-primary mb-4 font-weight-bold">Reset Password</h1>
                        </div>
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="user" method="POST" action="{{ route('password.updateByEmail') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user"
                                    id="email" placeholder="Email Address.." name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="mt-2 text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    id="password" placeholder="Tulis Password Baru Anda.." name="password" required>
                                @error('password')
                                    <div class="mt-2 text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    id="password_confirmation" placeholder="Konfirmasi Password Baru Anda.." name="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="showPassword" onclick="togglePassword()">
                                    <label class="custom-control-label" for="showPassword">Show New Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Reset Password
                            </button>
                        </form>
                        <hr>
                        <div class="text-start">
                            <a class="medium" href="{{ url('/') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Script Show Password --}}
    <script src="{{ asset('js/reset-password.js') }}"></script>
</div>
@endsection
