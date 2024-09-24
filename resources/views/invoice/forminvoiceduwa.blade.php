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
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $kode_inv->no_hp }}" readonly placeholder="Format : +62812345678" >
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="kode" class="text-primary small">Kode Invoice</label>
                            <input type="text" class="form-control" id="kode" name="kode" value="{{ $kode_inv->invoice_number }}" readonly placeholder="Format : +62812345678" >
                        </div>
                        
                    </div>
                    
                    <!-- Radio Button for Package Options -->
                    <div class="form-group">
                        <label class="text-primary small">Jenis Barang</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="lanyard" value="Lanyard" required>
                            <label class="form-check-label" for="lanyard">Lanyard</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="lanyard_id_card" value="Lanyard + ID Card" required>
                            <label class="form-check-label" for="lanyard_id_card">Lanyard + ID Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="lanyard_id_card_holder" value="Lanyard + ID Card + Holder" required>
                            <label class="form-check-label" for="lanyard_id_card_holder">Lanyard + ID Card + Holder</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="non_lanyard" value="Non Lanyard" required>
                            <label class="form-check-label" for="non_lanyard">Non Lanyard</label>
                        </div>
                    </div>

                    <!-- Checkbox Options for Lanyard and Lanyard + ID Card + Holder -->
                    <div id="lanyardOptions" class="form-group" style="display:none;">
                        <label class="text-primary small">Paket Lanyard</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardTali" value="1" checked>
                            <label class="form-check-label" for="lanyardTali">Tali</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardStopper" value="1" checked>
                            <label class="form-check-label" for="lanyardStopper">Stopper</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardKail" value="1" checked>
                            <label class="form-check-label" for="lanyardKail">Kail</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardKertas" value="1" >
                            <label class="form-check-label" for="lanyardKertas">Kertas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardKertasDob" value="2" checked>
                            <label class="form-check-label" for="lanyardKertasDob">Kertas Dobel</label>
                        </div>
                        <div class="form-check" id="idCardOption" style="display:none;">
                            <input class="form-check-input" type="checkbox" name="id_card" id="idCard" value="ID CARD" >
                            <label class="form-check-label" for="idCard">ID Card</label>
                        </div>
                        <div class="form-check" id="idCardOption2" style="display:none;">
                            <input class="form-check-input" type="checkbox" name="id_card" id="idCard2" value="ID CARD 2" checked>
                            <label class="form-check-label" for="idCard2">ID Card 2</label>
                        </div>
                        <!-- Checkbox for Holder in Lanyard + ID Card + Holder package -->
                        <div class="form-check" id="holderOption" style="display:none;">
                            <input class="form-check-input" type="checkbox" name="holder" id="holder" value="HOLDER" checked>
                            <label class="form-check-label" for="holder">Holder</label>
                        </div>
                    </div>

                    <!-- Non Lanyard Options -->
                    <div id="nonLanyardOptions" class="form-group" style="display:none;">
                        <label for="selectUser" class="text-primary small">Barang yang tersedia</label>
                        <select class="form-control" id="selectUser" name="barang" style="width: 100%;"></select>
                    </div>

                    <!-- Quantity and Pricing -->
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="Jumlah" class="text-primary small">Jumlah</label>
                            <input type="number" class="form-control" id="Jumlah" name="jumlah" placeholder="Masukkan Jumlah Produk yang dipilih" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga" class="text-primary small">Harga</label>
                            <input type="number" class="form-control" id="Harga" name="harga" placeholder="Masukkan Harga Satuan" required>
                        </div>
                    </div>

                    <!-- Checkbox for "Harga Pas" -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hargaPas" name="harga_pas">
                            <label class="form-check-label" for="hargaPas">Harga Pas</label>
                        </div>
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
