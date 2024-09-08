@extends('layout.master1.master')
@section('title', 'Tambah Barang')

@section('content')


@include('utils.notif')


<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Barang</h6>
        </div>
        <div class="card-body p-0">
                <div class="card">
                    <div class="card-body">
                        <p>Nama Barang : {{ $data->nama }} </p> 
                        <p>Jumlah (Satuan) : {{ $data->jumlah_satuan }}</p> 
                        <p>Jumlah (Pack) : {{ $data->jumlah_pack }}</p>
                    </div>
                </div>
                    <div class="p-5">
                        <form class="user" method="POST" action="{{ route("update.barang.kurang") }}">
                            @csrf
                            <div class="form-group">
                                <label for="NamaBarang" class="text-primary small">Nama Barang</label>
                                <input type="text" class="form-control form-control-user" id="NamaBarang" name="nama" placeholder="Masukkan Nama Barang" value="{{ $data->nama }}" readonly>
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="JumlahSatuan" class="text-primary small">Jumlah (Satuan)</label> --}}
                                <input type="hidden" class="form-control form-control-user" id="JumlahSatuan" name="jumlah_satuan" placeholder="Masukkan Jumlah dalam Pack" value="{{ $data->jumlah_satuan }}" >
                            {{-- </div> --}}
                            <div class="form-group">
                                <label for="JumlahPcs" class="text-primary small">Jumlah (Pack)</label>
                                <input type="number" class="form-control form-control-user" id="JumlahPcs" name="jumlah_pack" placeholder="Masukkan Jumlah dalam Pcs" value="{{ $data->jumlah_pack }}">
                            </div>
                            <div class="form-group">
                                <label for="JumlahPcs" class="text-primary small">Jumlah (Pcs)</label>
                                <input type="number" class="form-control form-control-user" id="JumlahPcs" name="jumlah_satuan" placeholder="Masukkan Jumlah dalam Pcs" value="{{ $data->jumlah_satuan }}">
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="JumlahPcs" class="text-primary small">Jumlah (Pcs)</label> --}}
                                <input type="hidden" class="form-control form-control-user" id="JumlahPcs" name="id" placeholder="Masukkan Jumlah dalam Pcs" value="{{ $data->id }}">
                            {{-- </div> --}}
                            <hr>
                            <button  class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">
                                Kirim
                            </button>
                            <a href="{{ route('index.inven') }}" class=" btn btn-lg btn-danger shadow-sm rounded-pill" >
                                <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali</a>
                        </form>
            
        </div>
    </div>
@endsection