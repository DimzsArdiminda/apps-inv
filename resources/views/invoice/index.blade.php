@extends('layout.master1.master')
@section('title', 'Invoice')
@section('menuInvoice', 'active')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ url('/dashboard/invoice/form-invoice') }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Invoice</a>
</div>

@include('utils.notif')

<!-- Invoice Table -->
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Invoice</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Invoice Number</th>
                        <th>Status</th>
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
                        <td>
                            @if($inv->status == 'dp')
                                <span class="badge badge-danger">{{ $inv->status }}</span>
                            @elseif($inv->status == 'selesai')
                                <span class="badge badge-success">{{ $inv->status }}</span>
                            @endif
                        <td>
                            <a href="{{ route('invoiceFull', $inv->invoice_number) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-shopping-basket"></i>
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete3('{{ $inv->invoice_number }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-form-{{ $inv->invoice_number }}" action="{{ route('delete.invoice', $inv->invoice_number) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                {{--  --}}
                                <button type="button" class="btn btn-danger mb-3" onclick="confirmDelete3('{{ $inv->invoice_number }}')">Hapus</button>
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

<script>
    function confirmDelete3(id) {
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