@extends('layout.master3.master3')
@section('title.InvoiceFull')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<div style="width: 100%; max-width: 900px; margin: 0 auto; font-family: 'Bebas Neue', sans-serif; font-size: 12px;">
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            {{-- image --}}
            <td>
                <img src="img/logo.jpg" alt="" srcset="" style="width: 150px">
            </td>
            <td colspan="2" style="padding: 20px; border-bottom: 2px solid #000;">
                <h3 style="margin: 0; font-weight: bold;">Costum Craft</h3>
                <p style="margin: 5px 0; font-size: 10px;">Perum Dwiga Regency A2/06 Malang - telp 087765748275</p>
            </td>
        </tr>
    </table>

    <h5 style="text-align: right; margin-right: 20px; font-size: 10px;">Sales Order</h5>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; border: 1px solid #000; padding: 15px;">
        <tr>
            <td style="padding: 10px; width: 50%;">
                <p style="font-size: 10px;"><b>Sales: Office</b><br>Dikirim ke:{{ $data[0]->nama }} <br>{{ \Carbon\Carbon::parse($data[0]->created_at)->format('d - F - Y') }}</p>
            </td>
            <td style="padding: 10px; width: 50%; text-align: right;">
                <p style="margin: 0; font-size: 10px;">{{ $data[0]->invoice_number }}</p>
                <p style="font-size: 10px;">telp: {{ $data[0]->no_hp }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <thead>
            <tr style="background-color: #000; color: #fff;">
                <th style="border: 1px solid #000; padding: 10px; font-size: 10px;">#</th>
                <th style="border: 1px solid #000; padding: 10px; font-size: 10px;">Nama Barang</th>
                <th style="border: 1px solid #000; padding: 10px; font-size: 10px;">Jumlah</th>
                <th style="border: 1px solid #000; padding: 10px; font-size: 10px;">Harga Barang</th>
                <th style="border: 1px solid #000; padding: 10px; font-size: 10px;">Total Harga / item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td style="border: 1px solid #000; padding: 10px; font-size: 10px;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #000; padding: 10px; font-size: 10px;">{{ $item->nama_barang }}</td>
                <td style="border: 1px solid #000; padding: 10px; font-size: 10px;">{{ $item->jumlah_barang }}</td>
                <td style="border: 1px solid #000; padding: 10px; font-size: 10px;">{{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                <td style="border: 1px solid #000; padding: 10px; font-size: 10px;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; padding: 10px; solid #000;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding: 10px;">
                <p style="font-size: 10px;">Pembayaran via BCA No Rek:<br>3151685275</p>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top; padding: 10px;">
                @php
                    $grand_total = $data->sum('total_harga');
                    $total_dibayar = $data->sum('uang_dp_lunas');
                    $total_sisa = $grand_total - $total_dibayar;
                @endphp
                <p style="font-weight: bold; font-size: 10px;">Total: Rp {{ number_format($grand_total, 0, ',', '.') }}</p>
                <p style="font-size: 10px;">Sudah Dibayar: Rp {{ number_format($total_dibayar, 0, ',', '.') }}</p>
                <p style="font-weight: bold; font-size: 10px;">Kekurangan: Rp {{ number_format($total_sisa, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>

    <div style="margin-top: 50px; border-top: 2px solid #000; padding-top: 10px;">
        <p style="font-size: 10px;">Owner</p>
        <p style="font-weight: bold; font-size: 10px;"><b>Rio Alfio R</b></p>
    </div>
</div>
@endsection
