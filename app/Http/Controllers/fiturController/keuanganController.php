<?php

namespace App\Http\Controllers\fiturController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pemasukan_pengeluaran;

class keuanganController extends Controller
{
    // Menampilkan semua data anggaran
    public function index()
    {
        // Mengelompokkan data berdasarkan bulan dan jenis, kemudian menjumlahkan 'jumlah'
        $data = pemasukan_pengeluaran::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan, jenis, SUM(jumlah) as total_jumlah')
            ->groupBy('bulan', 'jenis')
            ->get();
    
        return view('pemasukan.pemasukan', compact('data'));
    }
    
    // Menampilkan chart anggaran
    public function chartData()
{
    $anggaran = pemasukan_pengeluaran::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan, jenis, SUM(jumlah) as total_jumlah')
        ->groupBy('bulan', 'jenis')
        ->get();

    $tanggal = [];
    $pemasukan = [];
    $pengeluaran = [];

    foreach ($anggaran as $data) {
        if (!in_array($data->bulan, $tanggal)) {
            $tanggal[] = $data->bulan;  // Memastikan bahwa bulan hanya sekali masuk ke array
        }

        if ($data->jenis == 'pemasukan') {
            $pemasukan[] = $data->total_jumlah;
        } elseif ($data->jenis == 'pengeluaran') {
            $pengeluaran[] = $data->total_jumlah;
        }
    }

    return response()->json([
        'tanggal' => $tanggal,
        'pemasukan' => $pemasukan,
        'pengeluaran' => $pengeluaran,
    ]);
}






    // Menampilkan form untuk membuat anggaran baru
    public function create()
    {
        return view('pemasukan.create');
    }

    // Menyimpan data anggaran baru
    public function store(Request $request)
    {
        // dd($request->all());
        $data = new pemasukan_pengeluaran();
        $data->tanggal = $request->tanggal;
        $data->jenis = $request->type;
        $data->jumlah = $request->jumlah;
        $data->keterangan = $request->keterangan;
        $data->save();


        return redirect('/dashboard/anggaran')->with('success', 'Anggaran berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit anggaran
    public function edit($id)
    {
        $data = pemasukan_pengeluaran::findOrFail($id);
        return view('pemasukan.edit', compact('data'));
    }

    // Mengupdate data anggaran
    public function update(Request $request, $id)
    {
        $data = pemasukan_pengeluaran::find($id);
        $data->tanggal = $request->tanggal;
        $data->pemasukan = $request->pemasukan;
        $data->pengeluaran = $request->pengeluaran;
        $data->keterangan = $request->keterangan;
        $data->save();

        return redirect('/dashboard/anggaran')->with('success', 'Data anggaran berhasil diperbarui');
    }


    // Menghapus data anggaran
    public function delete($id)
    {
        $data = pemasukan_pengeluaran::findOrFail($id);
        $data->delete();

        return redirect('/dashboard/anggaran')->with('success', 'Anggaran berhasil dihapus');
    }
}
