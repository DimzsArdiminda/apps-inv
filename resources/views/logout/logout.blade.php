@extends('layout.master2.master2')
@section('title', 'LogOut')

@section('content')
   <!-- Outer Row -->


    <div class="col-xl-12 col-lg-12 col-md-9" >

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Log Out landing Page</h6>
            </div>
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-password-image">
                            <img class="img-fluid"  src="{{ asset('img/security 4.jpg') }}">
                    </div>
                    <div class="col-lg-6" style="align-content: center">
                        <div class="p-5">
                            <div class="text-start">
                                <h1 class="display-3 text-primary mb-4 font-weight-bold">You're Logged Out</h1>
                                <p class="display-5 my-4 font-weight-bold ">Anda telah Terlog Out, untuk kembali ke website silahkan
                                    kembali ke halaman Login !
                                </p>
                            </div>
                       <hr>
                       <div class="text-start">
                        <a class="medium" href="{{ url('/') }}">Return to Login Page!</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection