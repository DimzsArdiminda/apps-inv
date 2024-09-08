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
            <div class="p-5">
                <form class="user" method="POST" action="{{ route("add.barang") }}">
                    @csrf
                    <div class="form-group">
                        <label for="NamaBarang" class="text-primary small">Nama Barang</label>
                        <div class="input-group">
                            <select class="form-control form-control-user @error('nama') is-invalid @enderror" id="NamaBarangSelect" name="nama" required>
                                <option value="" disabled selected>Pilih Nama Barang</option>
                                <option value="KERTAS">KERTAS</option>
                                <option value="KAIL">KAIL</option>
                                <option value="STOPPER">STOPPER</option>
                                <option value="TALI">TALI</option>
                                <option value="custom">Input Custom</option>
                            </select>
                            <input type="text" class="form-control form-control-user d-none mt-2 @error('nama') is-invalid @enderror" id="CustomNamaBarang" name="nama_custom" placeholder="Masukkan Nama Barang Custom">
                        </div>
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="JumlahSatuan" class="text-primary small">Jumlah - Satuan </label>
                        <input type="number" class="form-control form-control-user" id="JumlahSatuan" name="jumlah_satuan" placeholder="Masukkan Jumlah dalam Pack" required>
                    </div>
                    <div class="form-group">
                        <label for="JumlahPcs" class="text-primary small">Jumlah - Pack </label>
                        <input type="number" class="form-control form-control-user" id="JumlahPcs" name="jumlah_pack" placeholder="Masukkan Jumlah dalam Pcs" required>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-lg px-5 rounded-pill" type="submit">
                        Kirim
                    </button>
                    <a href="{{ route('index.inven') }}" class=" btn btn-lg btn-danger shadow-sm rounded-pill">
                        <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('NamaBarangSelect').addEventListener('change', function() {
        var selectElement = document.getElementById('NamaBarangSelect');
        var customInput = document.getElementById('CustomNamaBarang');

        if (this.value === 'custom') {
            selectElement.classList.add('d-none');  // Hide the dropdown
            customInput.classList.remove('d-none');  // Show the custom input
            customInput.setAttribute('required', true);
            customInput.focus();  // Automatically focus the input field for better UX
        }
    });

    document.getElementById('CustomNamaBarang').addEventListener('blur', function() {
        if (this.value === '') {
            var selectElement = document.getElementById('NamaBarangSelect');
            selectElement.classList.remove('d-none');  // Show the dropdown again if input is empty
            this.classList.add('d-none');  // Hide the custom input field
            this.removeAttribute('required');  // Remove required attribute when hidden
        }
    });
</script>

@endsection
