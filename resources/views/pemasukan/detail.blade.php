@extends('layout.master1.master')
@section('title', 'Detail Anggaran')
@section('menuMasuk', 'active')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Anggaran Bulan {{ $bulan }}</h6>
            <a href="{{ url('/dashboard/anggaran') }}" class="btn btn-primary btn-sm float-right">Kembali</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('F j, Y') }}</td>
                                <td>{{ $item->jenis == 'pemasukan' ? $item->jumlah : '-' }}</td>
                                <td>{{ $item->jenis == 'pengeluaran' ? $item->jumlah : '-' }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ url('/dashboard/anggaran/edit/' . $item->id) }}"
                                        class="btn btn-sm btn-warning">Ubah</a>

                                    <form action="{{ url('/dashboard/anggaran/delete/' . $item->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
