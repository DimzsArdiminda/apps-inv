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
            ->get()
            ->groupBy('bulan');
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
                $tanggal[] = $data->bulan;
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

    // Method buat nampilin detail anggaran per bulan dan jenisnya
    public function detail($bulan, $jenis)
    {
        $data = pemasukan_pengeluaran::whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulan])
            ->where('jenis', $jenis)
            ->orderBy('tanggal')
            ->get();

        return view('pemasukan.detail', compact('data', 'bulan', 'jenis'));
    }



    // Menampilkan form untuk membuat anggaran baru
    public function create()
    {
        return view('pemasukan.create');
    }

    // Menyimpan data anggaran baru
    public function store(Request $request)
    {
        $tanggal = $request->tanggal;
        $jenis = $request->type;
        $jumlah = $request->jumlah;
        $keterangan = $request->keterangan;

        $existingEntry = pemasukan_pengeluaran::where('tanggal', $tanggal)
            ->where('jenis', $jenis)
            ->first();

        if ($existingEntry) {
            $existingEntry->jumlah += $jumlah;
            $existingEntry->keterangan = $keterangan;
            $existingEntry->save();
        } else {
            $data = new pemasukan_pengeluaran();
            $data->tanggal = $tanggal;
            $data->jenis = $jenis;
            $data->jumlah = $jumlah;
            $data->keterangan = $keterangan;
            $data->save();
        }

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
        $data->jenis = $request->type;
        $data->jumlah = $request->jumlah; // Pastikan kamu ingin memperbarui jumlah juga
        $data->keterangan = $request->keterangan;
        $data->save();

        return redirect('/dashboard/anggaran')->with('success', 'Data anggaran berhasil diperbarui');
    }

    // Menghapus data anggaran berdasarkan id
    public function destroy($id)
    {
        $data = pemasukan_pengeluaran::findOrFail($id);
        $data->delete();

        return redirect('/dashboard/anggaran')->with('success', 'Anggaran berhasil dihapus');
    }

    // Menghapus data anggaran berdasarkan bulan dan jenis
    public function deleteByMonthAndJenis($bulan, $jenis)
    {
        $data = pemasukan_pengeluaran::whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulan])
            ->where('jenis', $jenis)
            ->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
