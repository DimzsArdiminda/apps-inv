@extends('layout.master1.master')
@section('title', 'Anggaran')
@section('menuMasuk', 'active')

@section('content')

    @include('utils.notif')
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Rekapan Total Anggaran</h6>
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
        <a href="{{ url('/dashboard/anggaran/form-anggaran') }}"
            class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-success shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Anggaran</a>
        <a href="#" id="downloadBtn" onclick="downloadExcel()"
            class="d-none d-sm-inline-block mb-2 btn btn-md btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Download
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Total Anggaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Bulan</th>
                            <th colspan="2" class="text-center">Tipe</th>
                            <th rowspan="2" class="aksi-col">Aksi</th>
                        </tr>
                        <tr>
                            <th>Total Pemasukan</th>
                            <th>Total Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $bulan => $items)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('anggaran.detail', $bulan) }}">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->format('F, Y') }}
                                    </a>
                                </td>
                                <td>{{ $items->where('jenis', 'pemasukan')->sum('total_jumlah') ?? '-' }}</td>
                                <td>{{ $items->where('jenis', 'pengeluaran')->sum('total_jumlah') ?? '-' }}</td>
                                <td>
                                    <form id="delete-form-{{ $loop->iteration }}"
                                        action="{{ url('/dashboard/anggaran/delete/month/' . $bulan) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ $loop->iteration }}')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ url('/dashboard/anggaran/chart-data') }}')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('chart').getContext('2d'); // Menggunakan context 2D
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.tanggal,
                            datasets: [{
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        function downloadExcel() {
    // Get the table
    var table = document.getElementById("dataTable");

    // Convert table to worksheet
    var ws = XLSX.utils.table_to_sheet(table);

    // Get the range of cells in the worksheet
    const range = XLSX.utils.decode_range(ws['!ref']);

    // Remove "Aksi" column (index 4) and its content
    for (let R = range.s.r; R <= range.e.r; ++R) {
        const address = XLSX.utils.encode_cell({ r: R, c: 4 });
        delete ws[address];
    }

    // Adjust column widths
    ws['!cols'] = ws['!cols'] || [];
    table.querySelectorAll('thead tr th').forEach((th, i) => {
        // Check if column index is less than 4 to avoid index errors
        if (i !== 4) {
            ws['!cols'][i] = { width: th.innerText.length + 10 };
        }
    });

    // Create workbook and add the worksheet
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Daftar Anggaran");

    // Generate Excel file and force download
    var wbout = XLSX.write(wb, {
        bookType: 'xlsx',
        type: 'binary'
    });

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    saveAs(new Blob([s2ab(wbout)], {
        type: "application/octet-stream"
    }), "daftar_total_anggaran.xlsx");
}

    </script>

@endsection
