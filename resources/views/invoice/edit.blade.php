@extends('layout.master1.master')
@section('title', 'Form Invoice')

@section('content')

@include('utils.notif')

<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Invoice Edit</h6>
        </div>
        <div class="card-body p-0">
            <div class="p-5">
                <form class="user" method="POST" action="{{ route('save.barang.edit') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="text-primary small">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" placeholder="Masukkan Nama Pembeli" required>
                            <input type="hidden" class="form-control"  name="id" value="{{ $data->id }}" placeholder="Masukkan Nama Pembeli" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="text-primary small">No HP (opsional)</label>
                            <input type="text" class="form-control"  name="no_hp" value="{{ $data->no_hp }}" placeholder="Format : +62812345678">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="text-primary small">Invoice Number</label>
                            <input type="text" class="form-control" name="invoice_number" value="{{ $data->invoice_number }}"  readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang" class="text-primary small">Nama Barang</label>
                            <input type="text" class="form-control"  id="nama_barang" name="nama_barang" value="{{ $data->nama_barang }}"readonly>
                        </div>
                    </div> 


                    <!-- Quantity and Pricing -->
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="Jumlah" class="text-primary small">Jumlah</label>
                            <input type="hidden" class="form-control" id="Jumlah" name="jumlah_barang" value="{{ $data->jumlah_barang }}" placeholder="Masukkan Jumlah Produk yang dipilih" required>
                            <input type="number" class="form-control" id="Jumlah" name="jumlah_barang_baru" value="{{ $data->jumlah_barang }}" placeholder="Masukkan Jumlah Produk yang dipilih" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga" class="text-primary small">Harga</label>
                            <input type="number" class="form-control" id="Harga" name="harga_barang" value="{{ $data->harga_barang }}" placeholder="Masukkan Harga Satuan" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hargaPas" name="harga_pas">
                            <label class="form-check-label" for="hargaPas">Harga Pas</label>
                        </div>
                    </div>

                    <!-- Checkbox for "Harga Pas" -->
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
     $(document).ready(function(){
        $('#selectUser').select2({
        placeholder: 'Masukkan Nama Barang',
        ajax: {
            url: '{{ route("select.user") }}',
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

    // Handle mutual exclusivity between Kertas and Kertas Dobel
    $('#lanyardKertas').on('change', function () {
        if ($(this).is(':checked')) {
            $('#lanyardKertasDob').prop('checked', false);
        }
    });

    $('#lanyardKertasDob').on('change', function () {
        if ($(this).is(':checked')) {
            $('#lanyardKertas').prop('checked', false);
        }
    });

    // Handle mutual exclusivity between ID Card and ID Card 2
    $('#idCard').on('change', function () {
        if ($(this).is(':checked')) {
            $('#idCard2').prop('checked', false);
        }
    });

    $('#idCard2').on('change', function () {
        if ($(this).is(':checked')) {
            $('#idCard').prop('checked', false);
        }
    });

     })
</script>
@endsection
