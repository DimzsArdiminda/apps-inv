@extends('layout.master1.master')
@section('title', 'Detail Anggaran')
@section('menuMasuk', 'active')

@section('content')

<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Anggaran Bulan {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</h6>
            <div>
                <a href="{{ url('/dashboard/anggaran') }}" class="d-none d-sm-inline-block mb-2 btn btn-md btn-primary shadow-sm">Kembali</a>
                <button id="downloadBtn" class="d-none d-sm-inline-block mb-2 btn btn-md btn-success shadow-sm mr-2"> <i class="fas fa-download fa-sm text-white-50"></i> Download Excel</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah Uang Masuk / Keluar</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('F j, Y') }}</td>
                                <td>{{ ucfirst($item->jenis) }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ url('/dashboard/anggaran/edit/' . $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ url('/dashboard/anggaran/delete/' . $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('downloadBtn').addEventListener('click', function() {
        // Get the table
        var table = document.getElementById("dataTable");

        // Convert table to worksheet
        var ws = XLSX.utils.table_to_sheet(table);

        // Remove "Aksi" column (index 5) and its data
        var range = XLSX.utils.decode_range(ws['!ref']);
        for (var R = range.s.r; R <= range.e.r; ++R) {
            var cell_ref = XLSX.utils.encode_cell({ r: R, c: 5 });
            delete ws[cell_ref];
        }

        // Adjust column width
        const columnWidths = [];
        table.querySelectorAll('thead tr th').forEach((th, i) => {
            if (i !== 5) {
                columnWidths[i] = { width: th.innerText.length + 10 };
            }
        });
        ws['!cols'] = columnWidths;

        // Create workbook and add the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Detail Anggaran");

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

        // Get month from the blade variable
        var monthName = "{{ \Carbon\Carbon::parse($bulan)->format('F_Y') }}";
        var filename = "detail_anggaran_" + monthName + ".xlsx";

        saveAs(new Blob([s2ab(wbout)], {
            type: "application/octet-stream"
        }), filename);
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
        });
    }
</script>

@endsection
