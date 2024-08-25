@extends('layout.master1.master')
@section('title', 'Anggaran')
@section('menuMasuk', 'active')

@section('content')

<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Rekap Anggaran tanggalan</h6>
            <a href="#" class="d-none d-sm-inline-block mb-2 btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Download</a>
        </div>
        <div class="card-body">
            <div width="900" height="450">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-2">
    <a href="{{ url('/dashboard/anggaran/form-anggaran') }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Anggaran</a>
        <a href="#" class="d-none d-sm-inline-block mb-2 btn btn-md btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Download</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Anggaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bulan</th>
                        <th>Tipe</th>
                        <th>Uang Masuk / Keluar </th>
                        {{-- <th>Keterangan</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->total_jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ url('/dashboard/anggaran/chart-data') }}')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('chart').getContext('2d'); // Menggunakan context 2D
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.tanggal,
                        datasets: [
                            {
                                label: 'Total Pemasukan',
                                data: data.pemasukan,
                                borderColor: 'blue',
                                fill: true,
                                backgroundColor: 'rgba(0, 0, 255, 0.1)',
                                tension: 0.4,
                                pointStyle: 'circle',
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                borderWidth: 2
                            },
                            {
                                label: 'Total Pengeluaran',
                                data: data.pengeluaran,
                                borderColor: 'red',
                                fill: true,
                                backgroundColor: 'rgba(255, 0, 0, 0.1)',
                                tension: 0.4,
                                pointStyle: 'circle',
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    usePointStyle: true,
                                    pointStyleWidth: 15
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 500
                            }
                        }
                    }
                });
            });
    });
</script>

@endsection
