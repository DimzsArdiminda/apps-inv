@extends('layout.master3.master3')
@section('title.InvoiceFull')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">
    {{-- Invoice Content --}}
    <div class="card shadow my-5">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Brand Invoice</h6>
        </div>

        <div class="card-body">
            {{-- Informasi Utama --}}
            <div class="">
                <h6 class="font-weight-bold text-info">{{ $data[0]->invoice_number }}</h6>
                <h6 class="font-weight-bold text-info" style="text-align: end">Office</h6>
                <p class="small" style="text-align: end">
                    Jl. Ngagel Madya V No.31, RT.000/RW.00, Baratajaya, Kec. Gubeng, Surabaya, Jawa Timur 60284
                    Telp. 081 246 700 400
                </p>
            </div>
            <hr>

            {{-- Informasi Penerima --}}
            <div class="row">
                <div class="col-lg-6">
                    <p class="small">Kepada: {{ $data[0]->nama }}</p>
                    <p class="small">No HP: {{ $data[0]->no_hp }}</p>
                    <p class="small">Alamat: {{ $data[0]->alamat }}</p>
                </div>
                <div class="col-lg-6 d-inline" style="text-align: end">
                    <p class="small">Invoice #{{ $data[0]->invoice_number }}<br>
                        Tanggal: {{ $data[0]->created_at->format('Y-m-d') }}
                    </p>
                </div>
            </div>

            {{-- Tabel Barang --}}
            <table class="table small" cellspacing="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Barang</th>
                        <th>Total Harga</th>
                        <th>Sisa Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah_barang }}</td>
                        <td>{{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah_barang * $item->harga_barang, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $sudah_dibayar = $item->sudah_dibayar ?? 0;  // Asumsi ada kolom sudah_dibayar
                                $total_harga = $item->jumlah_barang * $item->harga_barang;
                                $sisa_pembayaran = $total_harga - $sudah_dibayar;
                            @endphp

                            {{ $sisa_pembayaran > 0 ? number_format($sisa_pembayaran, 0, ',', '.') : 'Lunas' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            {{-- Informasi Tambahan --}}
            <div class="row">
                <div class="col-lg-3">
                    <p class="small">Hormat kami,<br>Zaidan Ahmad Waliuddin</p>
                </div>
                <div class="col-lg-6">
                    <p class="small">
                        Pembayaran bisa dilakukan melalui transfer ke rekening berikut:<br>
                        Rekening atas nama: Nur Kholik<br>
                        - BCA Syariah cab. Pucang anom Surabaya No. Rek. 02 900 11378
                    </p>
                </div>
                <div class="col-lg-3" style="text-align: end">
                    {{-- Menghitung total semua item --}}
                    @php
                        $grand_total = $data->sum(function($item) {
                            return $item->jumlah_barang * $item->harga_barang;
                        });

                        $total_dibayar = $data->sum('sudah_dibayar');
                        $total_sisa = $grand_total - $total_dibayar;
                    @endphp
                    <p class="font-weight-bold small">Total: Rp {{ number_format($grand_total, 0, ',', '.') }}</p>
                    <p class="small">Sudah dibayar: Rp {{ number_format($total_dibayar, 0, ',', '.') }}</p>
                    <p class="font-weight-bold small">Kekurangan: Rp {{ number_format($total_sisa, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
