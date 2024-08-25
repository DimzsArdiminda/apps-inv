@extends('layout.master1.master')
@section('title', 'Edit Anggaran')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Anggaran</h6>
        </div>
        <div class="card-body p-0">
            <div class="p-5">
                <form class="user" method="POST" action="{{ url('/dashboard/anggaran/update/'.$data->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tanggal" class="text-primary small">Bulan</label>
                        <input type="text" class="form-control form-control-user" id="tanggal" name="tanggal" placeholder="Masukkan tanggal" value="{{ $data->tanggal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Pemasukan" class="text-primary small">Pemasukan</label>
                        <input type="number" class="form-control form-control-user" id="Pemasukan" name="pemasukan" placeholder="Masukkan Jumlah Pemasukan" value="{{ $data->pemasukan }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Pengeluaran" class="text-primary small">Pengeluaran</label>
                        <input type="number" class="form-control form-control-user" id="Pengeluaran" name="pengeluaran" placeholder="Masukkan Jumlah Pengeluaran" value="{{ $data->pengeluaran }}" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="text-primary small">keterangan</label>
                        <textarea class="form-control form-control-user rounded" id="keterangan" name="keterangan" placeholder="Tulis keterangan" required style="height: 150px">{{ $data->keterangan }}</textarea>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">
                        Update
                    </button>
                    <a href="{{ url('/dashboard/anggaran') }}" class="btn btn-lg btn-danger shadow-sm rounded-pill">
                        <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection