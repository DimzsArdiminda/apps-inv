@extends('layout.master1.master')
@section('title.FormAnggaran')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Anggaran</h6>
        </div>
        <div class="card-body p-0">
                
                    <div class="p-5">
                        <form class="user" method="POST" action="">
                            @csrf
                            <div class="form-group">
                                <label for="Bulan" class="text-primary small">Bulan</label>
                                <input type="text" class="form-control form-control-user" id="Bulan" name="bulan" placeholder="Masukkan Bulan" required>
                            </div>
                            <div class="form-group">
                                <label for="Pemasukan" class="text-primary small">Pemasukan</label>
                                <input type="number" class="form-control form-control-user" id="Pemasukan" name="pemasukan" placeholder="Masukkan Jumlah Pemasukan" required>
                            </div>
                            <div class="form-group">
                                <label for="Pengeluaran" class="text-primary small">Pengeluaran</label>
                                <input type="number" class="form-control form-control-user" id="Pengeluaran" name="pengeluaran" placeholder="Masukkan Jumlah Pengeluaran" required>
                            </div>
                            <div class="form-group">
                                <label for="Laporan" class="text-primary small">Laporan</label>
                                <textarea class="form-control form-control-user rounded" id="Laporan" name="laporan" placeholder="Tulis Laporan" required style="height: 150px"></textarea>
                            </div>
                            <hr>
                            <button  class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">
                                Kirim
                            </button>
                            <a href="{{ url('/dashboard/anggaran') }}" class=" btn btn-lg btn-danger shadow-sm rounded-pill" >
                                <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali</a>
                        </form>

            
        </div>
    </div>
@endsection