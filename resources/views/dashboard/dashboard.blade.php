@extends('layout.master1.master')
@section('title', 'Dashboard')
@section('menuDash', 'active')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('/dashboard/inventaris/form-barang') }}" class="btn btn-light border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-3">
                        <div class="text-xl font-weight-bold text-primary text-uppercase">
                            Tambah Barang</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('/dashboard/anggaran/form-anggaran') }}" class="btn btn-light border-left-info shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-3">
                        <div class="text-xl font-weight-bold text-info text-uppercase">
                            Tambah Daftar Anggaran</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('/dashboard/invoice/form-invoice') }}" class="btn btn-light border-left-success shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-3">
                        <div class="text-xl font-weight-bold text-success text-uppercase">
                            Form Invoice</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-download fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>
@endsection