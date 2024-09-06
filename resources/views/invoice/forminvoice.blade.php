@extends('layout.master1.master')
@section('title', 'Form Invoice')

@section('content')

@include('utils.notif')

<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Invoice</h6>
        </div>
        <div class="card-body p-0">
            <div class="p-5">
                <form class="user" method="POST" action="{{ route('save.barang') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="text-primary small">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Pembeli" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="text-primary small">No HP (opsional)</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Format : +62812345678" >
                        </div>
                    </div>

                    <!-- Radio Button for Lanyard / Non Lanyard -->
                    <div class="form-group">
                        <label class="text-primary small">Jenis Barang</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="lanyard" value="Lanyard" required>
                            <label class="form-check-label" for="lanyard">Lanyard</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_barang" id="non_lanyard" value="Non Lanyard" required>
                            <label class="form-check-label" for="non_lanyard">Non Lanyard</label>
                        </div>
                    </div>

                    <!-- Checkbox for Lanyard options -->
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardKertas" value="1" checked>
                                    <label class="form-check-label" for="lanyardKertas">Kertas</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lanyard_options[]" id="lanyardKertasDob" value="2">
                                    <label class="form-check-label" for="lanyardKertasDob">Kertas Dobel</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown for Non Lanyard -->
                    <div id="nonLanyardOptions" class="form-group" style="display:none;">
                        <label for="selectUser" class="text-primary small">Barang yang tersedia</label>
                        <select class="form-control" id="selectUser" name="barang" style="width: 100%;"></select>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label for="Jumlah" class="text-primary small">Jumlah</label>
                            <input type="number" class="form-control" id="Jumlah" name="jumlah" placeholder="Masukkan Jumlah Produk yang dipilih" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga" class="text-primary small">Harga</label>
                            <!-- Initial input for price -->
                            <input type="number" class="form-control" id="Harga" name="harga" placeholder="Masukkan Harga Satuan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="harga_pas" id="harga_pas" value="1" checked>
                                <label class="form-check-label text-primary small" for="harga_pas">Harga Pas</label>
                            </div>
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
    $(document).ready(function () {
        // Show/Hide options based on radio selection
        $('input[name="jenis_barang"]').on('change', function () {
            if ($(this).val() === 'Lanyard') {
                $('#lanyardOptions').show();
                $('#nonLanyardOptions').hide();
            } else {
                $('#lanyardOptions').hide();
                $('#nonLanyardOptions').show();
            }
        });

        // Initialize Select2 for non-lanyard dropdown
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

        // Logic for showing dropdown for price when quantity is between 1 and 10
        $('#Jumlah').on('input', function () {
            var quantity = $(this).val();

            // If quantity is between 1 and 10, show the dropdown with suggestion
            if (quantity >= 1 && quantity <= 10) {
                $('#Harga').replaceWith(`
                    <select class="form-control" id="Harga" name="harga" required>
                        <option value="10000">10,000</option>
                        <option value="custom">Masukkan Harga Kustom</option>
                    </select>
                `);
                
                // Add event listener for custom price input
                $('#Harga').on('change', function () {
                    if ($(this).val() === 'custom') {
                        $('#Harga').replaceWith(`
                            <input type="number" class="form-control" id="Harga" name="harga" placeholder="Masukkan Harga Satuan" required>
                        `);
                    }
                });
            } else {
                // Revert back to the original input type number if outside the range
                $('#Harga').replaceWith(`
                    <input type="number" class="form-control" id="Harga" name="harga" placeholder="Masukkan Harga Satuan" required>
                `);
            }
        });

        // Logic for Kertas and Kertas Dobel checkboxes
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
    });
</script>
@endsection
