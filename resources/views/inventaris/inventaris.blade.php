@extends('layout.master1.master')
@section('title', 'Inventaris')
@section('menuInvent', 'active')

@section('content')
<div class="d-flex justify-content-end">
    <a href="{{ route('form.barang') }}" class="d-none d-sm-inline-block mx-1 mb-2 btn btn-md btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang</a>

    <a href="{{ route('export.inven') }}" class="d-none d-sm-inline-block mb-2 btn btn-md btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Download Data</a>
</div>

@include('utils.notif')

<!-- DataTales Example -->
<div class="container mb-3">
    @foreach ($dataGetJumlah as $item)
    @if ($item->jumlah_satuan <= 5)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>
                Nama Barang : {{ $item->nama }} <br>
                Sisa : {{ $item->jumlah_satuan }} satuan <br>
            </strong>
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
        </div>
    @endif
@endforeach
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah (Pack)</th>
                        <th>Jumlah (Satuan)</th>
                        <th>Pengisian Terakhir (Pack)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inventoryTableBody">
                    @foreach($data as $inventory)
                    <tr>
                        <td>{{ $inventory->nama }}</td>
                        <td>{{ $inventory->jumlah_pack }}</td>
                        <td>{{ $inventory->jumlah_satuan }}</td>
                        <td>{{ $inventory->pengisian_terakhir }}</td>
                        <td>
                            <a href="{{ route('update.barang', $inventory->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('index.tambah.barang', $inventory->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                            <a href="{{ route('index.kurang.barang', $inventory->nama) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-minus-circle"></i>
                            </a>
                            {{-- delete button with sweet alert --}}
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $inventory->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <!-- Hidden form for delete -->
                            <form id="delete-form-{{ $inventory->id }}" action="{{ route('delete', $inventory->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                {{--  --}}
                                <button type="button" class="btn btn-danger mb-3" onclick="confirmDelete('{{ $inventory->id }}')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- @include('utils.alerts') --}}
<script src="{{ asset('js/alert.js') }}"></script>
<!-- Include SweetAlert Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function confirmDelete(id) {
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
