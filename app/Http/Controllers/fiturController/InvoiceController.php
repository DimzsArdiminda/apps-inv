<?php

namespace App\Http\Controllers\fiturController;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Inv;
use Mpdf\Mpdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\pemasukan_pengeluaran;


class InvoiceController extends Controller
{


    public function getInvoice($kode)
    {
        // Ambil semua data invoice berdasarkan nomor invoice
        $data = Invoice::where('invoice_number', $kode)->get(); // Menggunakan get() untuk mendapatkan banyak data
            
        // Cek apakah data ditemukan
        if ($data->isEmpty()) {
            return redirect()->back()->withErrors('Invoice not found.');
        }

        // Kirimkan collection data ke dalam array
        $pdf = Pdf::loadView('invoice.invoiceFull.invoicefull', ['data' => $data]);

        // Unduh PDF
        return $pdf->download('invoice.pdf');
    }
    
    
    public function transaksi(Request $req){
        $getData = Invoice::where('invoice_number', $req->kode)->first();
        // dd($getData);
        
        if ($getData) {
            $getData->total_harga_keseluruhan = $req->total;
            $getData->status = $req->status;
            $getData->uang_dp_lunas = $req->uang_diterima;
            $getData->update();

            // Masukan ke tabel pemasukan 
            $data = new pemasukan_pengeluaran();
            $data->tanggal = date('Y-m-d');
            $data->jenis = 'pemasukan';
            $data->jumlah = $req->uang_diterima;
            $data->keterangan = 'Pemasukan dari penjualan barang '. $getData->nama_barang . ' dengan kode invoice '. $req->kode . ' dengan total harga '. $req->total;
            $data->save();
        }
    
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
    public function deleteInvoice($id){
        // dd($id);
        $delete = Invoice::where('invoice_number',$id);
        $delete->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    public function deleteItem($id){
        // dd($id);
        $delete = Invoice::where('id',$id);
        $delete->delete();
        return redirect('/dashboard/invoice')->with('success', 'Data berhasil dihapus');
    }
    public function tambahBarang($kode_inv)
    {
        $kode_inve = Invoice::where('invoice_number', $kode_inv)->first();
        // \dd($kode_inve);
        return view('invoice.forminvoiceduwa', ['kode_inv' => $kode_inve]);
    }
    public function saveBarang2(Request $request)
    {   
        // pengurangan barang
        $inv = Inv::where('nama', $request->barang)->first();
        $a = $request->jumlah;
        $b = $inv->jumlah_pack;
        $c = $inv->jumlah_satuan;

        // pengurangan satuan
        $sisa = $c - $a;

        // pengurangan barang
        if( $sisa <= 0){
            return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
        }

        $pengurang = $a % $sisa;
        if( $pengurang == 0){
            $jumlah_pack_baru = $b - 1;
        }else{
            $jumlah_pack_baru = $b;
        }
        
        $inv->update([
            'jumlah_pack' => $jumlah_pack_baru,
            'jumlah_satuan' => $sisa
        ]);

        // dd($request->all());
        $harga_total = $request->harga * $request->jumlah;
        $data = new Invoice();
        // data diri pembeli
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->alamat = $request->alamat;
        $data->email = $request->email;

        // data barang
        $data->invoice_number = $request->kode;
        $data->nama_barang = $request->barang;
        $data->jumlah_barang = $request->jumlah;
        $data->harga_barang = $request->harga;
        $data->total_harga = $harga_total;
        $data->save();

        

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    public function saveBarang(Request $request)
    {   
        
        if($request->jenis_barang == 'Lanyard'){
            // dd($request->all());
            // 0 => tali | 1 => stopper | 2 => kail | 3 => kertas
            $getTali = isset($request->lanyard_options[0]) ? $request->lanyard_options[0] * $request->jumlah : 0;
            $getStopper = isset($request->lanyard_options[1]) ? $request->lanyard_options[1] * $request->jumlah : 0;
            $getKail = isset($request->lanyard_options[2]) ? $request->lanyard_options[2] * $request->jumlah : 0;
            $getKertas = isset($request->lanyard_options[3]) ? $request->lanyard_options[3] * $request->jumlah : 0;

            // dd($getTali, $getStopper, $getKail, $getKertas);

            $getBarang = Inv::all();
            // dd($getBarang);
            // tali
            $tali = $getBarang->where('nama', 'TALI')->first();
            $jumlahTali = $tali->jumlah_satuan;
            
            // STOPPER
            $STOPPER = $getBarang->where('nama', 'STOPPER')->first();
            $jumlahSTOPPER = $STOPPER->jumlah_satuan;

            // KERTAS
            $KERTAS = $getBarang->where('nama', 'KERTAS')->first();
            $jumlahKERTAS = $KERTAS->jumlah_satuan;

            // STOPPER
            $KAIL = $getBarang->where('nama', 'KAIL')->first();
            $jumlahKAIL = $KAIL->jumlah_satuan;

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKertas = $jumlahKERTAS - $getKertas;
            $sisaKail = $jumlahKAIL - $getKail;

            // dd($sisaTali, $sisaStopper, $sisaKertas, $sisaKail);

            // jika barang <= 5 kembalikan request dengan alert 
            $barangKurang = [];
            if($sisaTali <= 5){
                $barangKurang[] = 'TALI';
            }
            if($sisaStopper <= 5){
                $barangKurang[] = 'STOPPER';
            }
            if($sisaKertas <= 5){
                $barangKurang[] = 'KERTAS';
            }
            if($sisaKail <= 5){
                $barangKurang[] = 'KAIL';
            }

            if(!empty($barangKurang)){
                $barangKurangStr = implode(', ', $barangKurang);
                return redirect()->back()->with('error', 'Barang ' . $barangKurangStr . ' tidak cukup, tambahkan persediaan barang');
            }


            // pengurangan pack 
            $penguranganPackTali = $getTali % $sisaTali;
            $penguranganPackStopper = $getStopper % $sisaStopper;
            $penguranganPackKertas = $getKertas % $sisaKertas;
            $penguranganPackKail = $getKail % $sisaKail;

            $jumlah_pack_baru_tali = $penguranganPackTali == 0 ? $tali->jumlah_pack - 1 : $tali->jumlah_pack;
            $jumlah_pack_baru_stopper = $penguranganPackStopper == 0 ? $STOPPER->jumlah_pack - 1 : $STOPPER->jumlah_pack;
            $jumlah_pack_baru_kertas = $penguranganPackKertas == 0 ? $KERTAS->jumlah_pack - 1 : $KERTAS->jumlah_pack;
            $jumlah_pack_baru_kail = $penguranganPackKail == 0 ? $KAIL->jumlah_pack - 1 : $KAIL->jumlah_pack;

            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            // update data tali, stopper, kertas and kail
            $updateTali = Inv::where('nama', 'TALI')->update([
                'jumlah_pack' => $jumlah_pack_baru_tali,
                'jumlah_satuan' => $sisaTali
            ]);
            $updateStopper = Inv::where('nama', 'STOPPER')->update([
                'jumlah_pack' => $jumlah_pack_baru_stopper,
                'jumlah_satuan' => $sisaStopper
            ]);
            $updateKertas = Inv::where('nama', 'KERTAS')->update([
                'jumlah_pack' => $jumlah_pack_baru_kertas,
                'jumlah_satuan' => $sisaKertas
            ]);
            $updateKail = Inv::where('nama', 'KAIL')->update([
                'jumlah_pack' => $jumlah_pack_baru_kail,
                'jumlah_satuan' => $sisaKail
            ]);

        }else{
            // pengurangan barang
            $inv = Inv::where('nama', $request->barang)->first();
            $a = $request->jumlah;
            $b = $inv->jumlah_pack;
            $c = $inv->jumlah_satuan;

            // pengurangan satuan
            $sisa = $c - $a;
            // dd($sisa);

            // pengurangan barang
            if( $sisa <= 0){
                return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
            }

            $pengurang = $a % $sisa;
            if( $pengurang == 0){
                $jumlah_pack_baru = $b - 1;
            }else{
                $jumlah_pack_baru = $b;
            }
            
            $inv->update([
                'jumlah_pack' => $jumlah_pack_baru,
                'jumlah_satuan' => $sisa
            ]);
        }

        
        $harga_total = $request->harga * $request->jumlah;
        $data = new Invoice();
        // data diri pembeli
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;

        // data barang
        $data->invoice_number = 'INV-'.rand(1000, 9999);
        $data->nama_barang = $request->barang;
        $data->jumlah_barang = $request->jumlah;
        $data->harga_barang = $request->harga;
        // $data->total_harga = $harga_total;
        $data->status = 'dp';
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    public function storeBarang(Request $request)
    {
        $query = $request->input('q');
    
        // Lakukan pencarian berdasarkan nama atau atribut lain yang diperlukan
        $users = Inv::where('nama', 'LIKE', "%$query%")
                             ->select('nama', 'jumlah_pack', 'jumlah_satuan') // Pilih kolom yang benar
                             ->get();
    
        // Format data untuk respons JSON
        $formattedUsers = $users->map(function($user) {
            return [
                'nama' => $user->nama,
                'jumlah_pack' => $user->jumlah_pack, 
                'jumlah_satuan' => $user->jumlah_satuan, 
            ];
        });
    
        // Kembalikan data dalam format JSON
        return response()->json(['results' => $formattedUsers]);
    }
    

    
    public function indexForm()
    {
       
        return view('invoice.forminvoice');
    }
    public function index()
    {
        $getData = Invoice::select('nama', 'no_hp', 'invoice_number', 'status')
            ->groupBy('nama', 'no_hp', 'invoice_number', 'status')
            ->get()->sortBy('status');
        return view('invoice.index', ['data' => $getData]);
    }
    
   public function indexData($getID){
        // dd($getID);
        $getData =  Invoice::where('invoice_number', $getID)->get();
        // total semua harga berdasarkan kode invoice
        $total = Invoice::where('invoice_number', $getID)->sum('harga_barang');
        $getKode = $getData->first()->invoice_number;
        $uang = $getData->first()->uang_dp_lunas;
        $sisa = $total - $uang;
        $status = $getData->first()->status;
        // dd($getData);
        return view('invoice.invoice', ['data' => $getData, 'total' => $total, 'uang' => $uang, 'sisa' => $sisa, 'status' => $status, 'kode' => $getKode]);
   }
}
