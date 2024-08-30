@extends('layout.master1.master')
@section('title', 'Form Anggaran')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Anggaran</h6>
        </div>
        <div class="card-body p-0">
            <div class="p-5">
                <form class="user" method="POST" action="{{ url('/dashboard/anggaran/store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal" class="text-primary small">Bulan</label>
                        <input type="date" class="form-control form-control-user" id="tanggal" name="tanggal" placeholder="Masukkan tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="type" class="text-primary small">Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="pemasukan" value="pemasukan" required>
                            <label class="form-check-label" for="pemasukan">
                                Pemasukan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="pengeluaran" value="pengeluaran" required>
                            <label class="form-check-label" for="pengeluaran">
                                Pengeluaran
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Jumlah" class="text-primary small">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control form-control-user" placeholder="10000">
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="text-primary small">keterangan</label>
                        <textarea class="form-control form-control-user rounded" id="keterangan" name="keterangan" placeholder="Tulis keterangan" required style="height: 150px"></textarea>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">
                        Kirim
                    </button>
                    <a href="{{ url('/dashboard/anggaran') }}" class="btn btn-lg btn-danger shadow-sm rounded-pill">
                        <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
