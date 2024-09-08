<?php

namespace App\Http\Controllers\fiturController;

use App\Http\Controllers\Controller;
// use App\Models\Inventaris;
use Illuminate\Http\Request;
use App\Models\inv;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class InventarisController extends Controller
{
    public function updatePengurangan(Request $request){
        // dd($request->all());
        $getid = Inv::where('id', $request->id)->first();
        // dd($getid);
        $getid->nama = $request->nama;
        $getid->jumlah_satuan = $request->jumlah_satuan;
        $getid->jumlah_pack = $request->jumlah_pack;
        $getid->update();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
    public function kurang($getNama) {
        $data = Inv::where('nama', $getNama)->first();
        return view('inventaris.pengurangan.index', ['data' => $data]);
    }
    // public function kurang($getNama) {
    //     $data = Inv::where('nama', $getNama)->first();
    //     // Simpan data dalam session
    //     session()->put('data', $data);
    //     return redirect('/dashboard/inventaris/');
    // }
    public function indexTambahBarang(Request $request){
        $getid = Inv::find($request->id);
        // dd($getid);
        return view('inventaris.tambahBarang', ['data' => $getid]);
    }
    public function addBarang(Request $request){
        // dd($request->all());
        $getid = Inv::where('id', $request->id)->first();
        // dd($getid);
        // satuan baru
        // ambil data
        $jumlahSaatini = $getid->jumlah_satuan; // satuan yang ada di database
        $jumlahPackSaatini = $getid->jumlah_pack; // pack yang ada di database


        // perhitungan awal data
        $per1pack = $jumlahSaatini / $jumlahPackSaatini; // jumlah satuan per pack
        $jumlahPackBaru = $request->jumlah_pack * $per1pack; // jumlah pack yang diinput
        $satuanBaru = $jumlahPackBaru + $jumlahSaatini; // jumlah pack yang diinput

        // update data
        $getid->jumlah_satuan = $satuanBaru;

        // pack yang diinput
        $packBaru = $jumlahPackSaatini + $request->jumlah_pack;
        $getid->jumlah_pack = $packBaru;

        // pengisian terakhir
        $getid->nama = $request->nama;
        $getid->pengisian_terakhir = $request->jumlah_pack;
        $getid->update();


        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    public function exportInventaris(){
        return Excel::download(new UsersExport, 'inventaris.xlsx');
    }
    public function delete(Request $request){
        // dd($request->all());
        $getid = Inv::find($request->id);
        $getid->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    public function indexEdit(Request $request){
        $getid = Inv::find($request->id);
        return view('inventaris.edit', ['data' => $getid]);
    }
    public function edit(Request $request){
        $getid = Inv::where('id', $request->id)->first();
        // dd($getid);
        $getid->nama = $request->nama;
        $getid->jumlah_satuan = $request->jumlah_satuan;
        $getid->jumlah_pack = $request->jumlah_pack;
        $getid->pengisian_terakhir = $request->jumlah_pack;
        $getid->jumlah_pack_asli = $request->jumlah_pack_asli;
        $getid->jumlah_satuan_asli = $request->jumlah_satuan_asli;
        // dd($request->all());
        $getid->update();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
    public function index()
    {
        $data = Inv::all();
        $dataGetJumlah = Inv::select('jumlah_satuan', 'nama')->get(); // Ambil data dari database
        return view('inventaris.inventaris', ['data' => $data, 'dataGetJumlah' => $dataGetJumlah]);
    }
    

    
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required|unique:inventaris',
            'jumlah_satuan' => 'required',
            'jumlah_pack' => 'required',
        ]);

        $bijian = $request->jumlah_satuan / $request->jumlah_pack;
        $pack = $request->jumlah_satuan / $bijian;

        $data = new Inv();
        $data->nama = strtoupper($request->nama);
        $data->jumlah_satuan = $request->jumlah_satuan;
        $data->jumlah_pack = $request->jumlah_pack;
        $data->pengisian_terakhir = $request->jumlah_pack;
        $data->jumlah_pack_asli = $pack;
        $data->jumlah_satuan_asli = $bijian;
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');

    }

}
