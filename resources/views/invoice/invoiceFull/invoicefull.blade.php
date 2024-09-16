@extends('layout.master3.master3')
@section('title.InvoiceFull')

@section('content')
<div style="width: 100%; max-width: 900px; margin: 0 auto; font-family: 'Fake Receipt', Arial, sans-serif;">
    <style>


        /* Pastikan seluruh elemen menggunakan font ini */
        body, h6, p, table, th, td {
            font-family: 'Courier New', Courier, monospace;
        }
    </style>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8f9fa;">
        <tr>
            <td colspan="2" style="padding: 20px; border-bottom: 2px solid #007bff;">
                <h6 style="margin: 0; font-weight: bold; color: #007bff; text-transform: uppercase;">Brand Invoice costumcraft.id</h6>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; vertical-align: top; width: 50%;">
                <h6 style="margin: 0; font-weight: bold; color: #17a2b8;">{{ $data[0]->invoice_number }}</h6>
                <p style="margin: 5px 0; font-size: 12px; color: #333;">Office</p>
                <p style="margin: 5px 0; font-size: 12px; color: #333;">
                    Perum Dwiga Regency A2/06, Malang, Jawa Timur, 65141<br>
                    Telp. 087765748275
                </p>
            </td>
            <td style="padding: 15px; vertical-align: top; width: 50%; text-align: right;">
                <p style="margin: 5px 0; font-size: 12px; color: #333;">
                    Invoice #: <strong>{{ $data[0]->invoice_number }}</strong><br>
                    Tanggal: <strong>{{ $data[0]->created_at->format('Y-m-d') }}</strong>
                </p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; border: 1px solid #ddd;">
        <thead style="background-color: #007bff; color: white;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">#</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Nama Barang</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Jumlah</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Harga Barang</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Total Harga / item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->nama_barang }}</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->jumlah_barang }}</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 20px; vertical-align: top; width: 33%; font-size: 12px; position: relative;">
                <p>Hormat kami,<br><br> <br><br>
                    <img src="img/logo.jpg" 
                         style="max-width: 100px; opacity: 0.5; position: absolute; top: 20; left: 0; transform: rotate(-15deg);">
                    <span style="position: relative; z-index: 2; margin-top: 80px;">Rio Alfio R</span>
                </p>
            </td>            
            <td style="padding: 20px; vertical-align: top; width: 33%; font-size: 12px;">
                <p>Pembayaran bisa dilakukan melalui transfer ke rekening berikut:<br>
                    Rekening atas nama: Rio Alfio Rado<br>
                    - Bca No. Rek. 3151685275</p>
            </td>
            <td style="padding: 20px; vertical-align: top; width: 33%; text-align: right; font-size: 12px;">
                @php
                    $grand_total = $data->sum('total_harga');
                    $total_dibayar = $data->sum('uang_dp_lunas');
                    $total_sisa = $grand_total - $total_dibayar;
                @endphp
                <p style="font-weight: bold; margin: 5px 0;">Total: Rp {{ number_format($grand_total, 0, ',', '.') }}</p>
                <p style="margin: 5px 0;">Sudah dibayar: Rp {{ number_format($total_dibayar, 0, ',', '.') }}</p>
                <p style="font-weight: bold; margin: 5px 0;">Kekurangan: Rp {{ number_format($total_sisa, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>
</div>
@endsection
