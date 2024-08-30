@extends('layout.master1.master')
@section('title', 'Form Invoice')

@section('content')

@include('utils.notif')

<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Invoice tambah dengan kode {{ $kode_inv->invoice_number }}</h6>
        </div>
        <div class="card-body p-0">
            <div class="p-5">
                <form class="user" method="POST" action="{{ route('save.barang.dua') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="text-primary small">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $kode_inv->nama }}" readonly placeholder="Masukkan Nama Pembeli" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="text-primary small">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $kode_inv->no_hp }}" readonly placeholder="Format : +62812345678" required>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="text-primary small">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $kode_inv->email }}" readonly placeholder="example.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="text-primary small">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat"  readonly placeholder="Masukkan Alamat" required> {{ $kode_inv->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="selectUser" class="text-primary small">Barang yang tersedia</label>
                            <select class="form-control" id="selectUser" name="barang" required style="width: 100%;"></select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="Jumlah" class="text-primary small">Jumlah</label>
                            <input type="number" class="form-control" id="Jumlah" name="jumlah" placeholder="Masukkan Jumlah Produk yang dipilih" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga" class="text-primary small">Harga</label>
                            <input type="number" class="form-control" id="Harga" name="harga" placeholder="Masukkan Harga Satuan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga" class="text-primary small">Kode Invoice</label>
                            <input type="text" class="form-control" id="Harga" name="kode" value="{{ $kode_inv->invoice_number }}" placeholder="Masukkan Kode Invoice" required readonly>
                        </div>
                        
                        {{-- <div class="col-md-4 mb-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status" class="text-primary small">Status</label>
                                    <div class="form-check ms-3">
                                        <input class="form-check-input" type="radio" name="status" id="dp" value="dp">
                                        <label class="form-check-label" for="dp">DP</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input class="form-check-input" type="radio" name="status" id="lunas" value="lunas">
                                        <label class="form-check-label" for="lunas">Lunas</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <hr>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">Kirim</button>
                            <a href="{{ url('/dashboard/invoice') }}" class="btn btn-lg btn-danger shadow-sm rounded-pill">
                                <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#selectUser').select2({
            placeholder: 'Masukkan Nama Barang',
            ajax: {
                url: '{{ route('select.user') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    var formattedData = data.results.map(function (item) {
                        return {
                            id: item.nama,
                            text: item.nama + ' - ' + item.jumlah_pack + ' pack - ' + item.jumlah_satuan + ' satuan'
                        };
                    });

                    return {
                        results: formattedData
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });
    });
</script>
@endsection
