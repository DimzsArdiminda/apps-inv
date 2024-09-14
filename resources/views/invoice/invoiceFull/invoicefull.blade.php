@extends('layout.master3.master3')
@section('title.InvoiceFull')

@section('content')
<div style="width: 100%; max-width: 900px; margin: 0 auto;">
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd; margin: 20px 0;">
        <tr>
            <td colspan="2" style="padding: 10px; border-bottom: 1px solid #ddd;">
                <h6 style="margin: 0; font-weight: bold; color: #007bff;">Brand Invoice costumcraft.id</h6>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px; vertical-align: top; width: 50%;">
                <h6 style="margin: 0; font-weight: bold; color: #17a2b8;">{{ $data[0]->invoice_number }}</h6>
                <p style="margin: 5px 0; font-size: 12px; color: #333;">Office</p>
                <p style="margin: 5px 0; font-size: 12px; color: #333;">
                    Jl. Ngagel Madya V No.31, RT.000/RW.00, Baratajaya, Kec. Gubeng, Surabaya, Jawa Timur 60284<br>
                    Telp. 081 246 700 400
                </p>
            </td>
            <td style="padding: 10px; vertical-align: top; width: 50%; text-align: right;">
                <p style="margin: 5px 0; font-size: 12px; color: #333;">
                    Invoice #{{ $data[0]->invoice_number }}<br>
                    Tanggal: {{ $data[0]->created_at->format('Y-m-d') }}
                </p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">#</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Barang</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Jumlah</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Harga Barang</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total Harga / item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->nama_barang }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->jumlah_barang }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 10px; vertical-align: top; width: 33%; font-size: 12px;">
                <p>Hormat kami,<br>Zaidan Ahmad Waliuddin</p>
            </td>
            <td style="padding: 10px; vertical-align: top; width: 33%; font-size: 12px;">
                <p>Pembayaran bisa dilakukan melalui transfer ke rekening berikut:<br>
                    Rekening atas nama: Nur Kholik<br>
                    - BCA Syariah cab. Pucang anom Surabaya No. Rek. 02 900 11378</p>
            </td>
            <td style="padding: 10px; vertical-align: top; width: 33%; text-align: right; font-size: 12px;">
                @php
                    $grand_total = $data->sum('total_harga');
                    $total_dibayar = $data->sum('uang_dp_lunas');
                    $total_sisa = $grand_total - $total_dibayar;
                @endphp
                <p style="font-weight: bold;">Total: Rp {{ number_format($grand_total, 0, ',', '.') }}</p>
                <p>Sudah dibayar: Rp {{ number_format($total_dibayar, 0, ',', '.') }}</p>
                <p style="font-weight: bold;">Kekurangan: Rp {{ number_format($total_sisa, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>
</div>
@endsection
