@extends('layout.master1.master')
@section('title', 'Invoice')
@section('menuInvoice', 'active')

@section('content')
<div class="d-flex justify-content-end mb-3">
    @if($data->isNotEmpty())  <!-- Pastikan $data tidak kosong -->
        @if ($status == 'dp')
            <button type="button" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-warning shadow-sm" data-toggle="modal" data-target="#modalForm">
                <i class="fas fa-money-bill-alt"></i> Transaksi Pembayaran
            </button>
            <a href="{{ route('tambah.barang.invc', $data->first()->invoice_number) }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pembelian</a>
        @endif
    @endif
    <a href="{{ route('export.invoice', $kode) }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-info shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Cetak Invoice</a>
   
    <a href="{{ url('/dashboard/invoice') }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-secondary shadow-sm">
        <i class="fas fa-backward fa-sm text-white-50"></i> Kembali ke Dashboard Invoice</a>
</div>

@include('utils.notif')

<!-- Invoice Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">Data Belanja kode {{ $data->first()->invoice_number }}</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Total Belanja</th>
                <td>Rp. {{ $total }}</td>
            </tr>
            <tr>
                <th>Uang Pembayaran</th>
                <td>Rp. {{ $uang }}</td>
            </tr>
            <tr>
                <th>Sisa Pembayaran</th>
                <td>Rp. {{ $sisa }}</td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td class="{{ $status == 'dp' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                    {{ $status == 'dp' ? 'DP' : 'Lunas' }}
                </td>
                
            </tr>
           
        </table>
        
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Invoice Number</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Harga Barang</th>
                        <th>Total Harga</th>
                        <th>Tanggal Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $inv)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inv->nama }}</td>
                        <td>{{ $inv->no_hp }}</td>
                        <td>{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->nama_barang }}</td>
                        <td>{{ $inv->jumlah_barang }}</td>
                        <td>{{ $inv->harga_barang }}</td>
                        <td>{{ $inv->total_harga }}</td>
                        <td>{{ $inv->created_at->format('Y-m-d') }}</td>
                        <td>
                            {{-- delete with sweet alert --}}
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete2({{ $inv->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            @if ($status == 'dp')
                                <a class="btn btn-warning btn-sm mt-2" href="{{ route("edit.invoice", $inv->id )}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endif
                            <form id="delete-form-{{ $inv->id }}" action="{{ route('delete.item', $inv->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger mb-3" onclick="confirmDelete('{{ $inv->id }}')">Hapus</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

{{-- modal with 3 form --}}
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form" action="{{ route('transaksi') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Form Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form -->
                    <div class="form-group">
                        <label for="total">Total Belanja</label>
                        <input type="number" class="form-control" id="total" name="total" value="{{ $total }}" required readonly> 
                    </div>
                    <div class="form-group">
                        <label for="uang_diterima">Uang Diterima</label>
                        <input type="number" class="form-control" id="uang_diterima" name="uang_diterima" required>
                        <input type="hidden" class="form-control" id="kode_pembayaran" name="kode" value="{{ $data->first()->invoice_number }}"  required>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="status" class="text-primary small">Status</label>
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="status" id="dp" value="dp" required>
                                <label class="form-check-label" for="dp">DP</label>
                            </div>
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="status" id="selesai" value="selesai" required>
                                <label class="form-check-label" for="selesai">Lunas</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    function confirmDelete2(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
