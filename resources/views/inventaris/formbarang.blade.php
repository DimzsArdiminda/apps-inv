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
                            <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror" id="NamaBarang" name="nama" placeholder="Masukkan Nama Barang" autocomplete="off" required>
                            <ul id="suggestions" class="list-group mt-5 d-none" style="position: absolute; z-index: 1000; width: 100%; max-height: 150px; overflow-y: auto;">
                                <!-- Suggestion list akan muncul di sini -->
                            </ul>
                            <button type="button" id="closeSuggestions" class="btn btn-sm btn-danger d-none mt-2">Tutup</button>
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
                    <a href="{{ route('index.inven') }}" class="btn btn-lg btn-danger shadow-sm rounded-pill">
                        <i class="fas fa-door-open fa-sm text-white-50"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const namaBarangInput = document.getElementById('NamaBarang');
    const suggestionsList = document.getElementById('suggestions');
    const closeSuggestionsButton = document.getElementById('closeSuggestions');

    const barangSuggestions = [
        "KERTAS",
        "KAIL",
        "STOPPER",
        "TALI",
        "ID CARD",
        "HOLDER"
    ];

    // Tampilkan suggestion list
    function displaySuggestions(suggestions) {
        suggestionsList.innerHTML = '';
        suggestions.forEach(item => {
            const suggestionItem = document.createElement('li');
            suggestionItem.classList.add('list-group-item', 'list-group-item-action', 'p-2', 'small');
            suggestionItem.textContent = item;
            suggestionsList.appendChild(suggestionItem);

            // Isi input ketika user menekan suggestion
            suggestionItem.addEventListener('click', function() {
                namaBarangInput.value = item;
                hideSuggestions(); // Sembunyikan daftar setelah memilih
            });
        });
        suggestionsList.classList.remove('d-none'); // Tampilkan daftar suggestion
        closeSuggestionsButton.classList.remove('d-none'); // Tampilkan tombol tutup
    }

    // Sembunyikan suggestion list dan tombol tutup
    function hideSuggestions() {
        suggestionsList.classList.add('d-none');
        closeSuggestionsButton.classList.add('d-none');
    }

    // Filter suggestion ketika pengguna mengetik
    namaBarangInput.addEventListener('input', function() {
        const input = this.value.toLowerCase();

        // Filter suggestion yang sesuai dengan input pengguna
        const filteredSuggestions = barangSuggestions.filter(item => item.toLowerCase().includes(input));

        // Jika input kosong, tampilkan semua suggestion
        if (input === '') {
            displaySuggestions(barangSuggestions);
        } 
        // Jika ada hasil yang cocok, tampilkan suggestion yang difilter
        else if (filteredSuggestions.length > 0) {
            displaySuggestions(filteredSuggestions);
        } 
        // Jika tidak ada hasil, tetap tampilkan semua suggestion
        else {
            displaySuggestions(barangSuggestions);
        }
    });

    // Tombol untuk menutup daftar suggestion
    closeSuggestionsButton.addEventListener('click', hideSuggestions);

    // Sembunyikan suggestion list jika pengguna klik di luar input dan daftar
    document.addEventListener('click', function(e) {
        if (!namaBarangInput.contains(e.target) && !suggestionsList.contains(e.target) && !closeSuggestionsButton.contains(e.target)) {
            hideSuggestions();
        }
    });
</script>

@endsection
