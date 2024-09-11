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
        $data = Invoice::where('invoice_number', $kode)->get();

        // Cek apakah data ditemukan
        if ($data->isEmpty()) {
            return redirect()->back()->withErrors('Invoice not found.');
        }

        // Perhitungan total dan status pembayaran
        $grand_total = $data->sum(function ($item) {
            return $item->jumlah_barang * $item->harga_barang;
        });

        $total_dibayar = $data->sum('sudah_dibayar');
        $total_sisa = $grand_total - $total_dibayar;

        // Proses data yang akan dikirim ke view
        $invoiceData = [
            'data' => $data,
            'grand_total' => $grand_total,
            'total_dibayar' => $total_dibayar,
            'total_sisa' => $total_sisa,
        ];

        // Kirimkan data ke view dan generate PDF
        $pdf = Pdf::loadView('invoice.invoiceFull.invoicefull', $invoiceData)->setPaper('a4', 'portrait');

        // Unduh PDF
        return $pdf->download('invoice.pdf');
    }

    
    
    public function transaksi(Request $req){
        // dd($req->all());
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
            $data->keterangan = 'Pemasukan dari penjualan barang '. $getData->nama_barang . ' dengan kode invoice '. $req->kode . '. Dari Total  '. $req->total;
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
        // dd($request->all());
        if($request->jenis_barang == 'Lanyard') {
            // Perhitungan total barang yang digunakan
            $getTali = isset($request->lanyard_options[0]) ? $request->lanyard_options[0] * $request->jumlah : 0;
            $getStopper = isset($request->lanyard_options[1]) ? $request->lanyard_options[1] * $request->jumlah : 0;
            $getKail = isset($request->lanyard_options[2]) ? $request->lanyard_options[2] * $request->jumlah : 0;
            $getKertas = isset($request->lanyard_options[3]) ? $request->lanyard_options[3] * $request->jumlah : 0;
    
            $getBarang = Inv::all();
    
            // Mendapatkan jumlah barang di database
            $tali = $getBarang->where('nama', 'TALI')->first();
            $jumlahTali = $tali->jumlah_satuan;
    
            $stopper = $getBarang->where('nama', 'STOPPER')->first();
            $jumlahStopper = $stopper->jumlah_satuan;
    
            $kail = $getBarang->where('nama', 'KAIL')->first();
            $jumlahKail = $kail->jumlah_satuan;
    
            $kertas = $getBarang->where('nama', 'KERTAS')->first();
            $jumlahKertas = $kertas->jumlah_satuan;
    
            // Menghitung sisa barang setelah pembelian
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahStopper - $getStopper;
            $sisaKail = $jumlahKail - $getKail;
            $sisaKertas = $jumlahKertas - $getKertas;
    
            // Validasi barang jika jumlahnya kurang dari minimum stok
            $barangKurang = [];
            if($sisaTali <= 5){
                $barangKurang[] = 'TALI';
            }
            if($sisaStopper <= 5){
                $barangKurang[] = 'STOPPER';
            }
            if($sisaKail <= 5){
                $barangKurang[] = 'KAIL';
            }
            if($sisaKertas <= 5){
                $barangKurang[] = 'KERTAS';
            }
    
            if(!empty($barangKurang)){
                $barangKurangStr = implode(', ', $barangKurang);
                return redirect()->back()->with('error', 'Barang ' . $barangKurangStr . ' tidak cukup, tambahkan persediaan barang');
            }
    
            // Menghitung sisa pack dan satuan setelah pembelian
            $jumlahPackTali = $getTali % $tali->jumlah_pack == 0 ? $tali->jumlah_pack - 1 : $tali->jumlah_pack;
            $jumlahPackStopper = $getStopper % $stopper->jumlah_pack == 0 ? $stopper->jumlah_pack - 1 : $stopper->jumlah_pack;
            $jumlahPackKail = $getKail % $kail->jumlah_pack == 0 ? $kail->jumlah_pack - 1 : $kail->jumlah_pack;
            $jumlahPackKertas = $getKertas % $kertas->jumlah_pack == 0 ? $kertas->jumlah_pack - 1 : $kertas->jumlah_pack;
    
            // Update data ke database
            $updateTali = Inv::where('nama', 'TALI')->update([
                'jumlah_pack' => $jumlahPackTali,
                'jumlah_satuan' => $sisaTali
            ]);
            $updateStopper = Inv::where('nama', 'STOPPER')->update([
                'jumlah_pack' => $jumlahPackStopper,
                'jumlah_satuan' => $sisaStopper
            ]);
            $updateKail = Inv::where('nama', 'KAIL')->update([
                'jumlah_pack' => $jumlahPackKail,
                'jumlah_satuan' => $sisaKail
            ]);
            $updateKertas = Inv::where('nama', 'KERTAS')->update([
                'jumlah_pack' => $jumlahPackKertas,
                'jumlah_satuan' => $sisaKertas
            ]);

            
        }else{
            // Dapatkan data inventaris berdasarkan nama barang
            $inv = Inv::where('nama', $request->barang)->first();

            // Jumlah yang diminta oleh pengguna
            $jumlahDiminta = $request->jumlah;

            // Jumlah total satuan yang ada
            $jumlahSatuan = $inv->jumlah_satuan;

            // Jumlah pack yang tersedia
            $jumlahPack = $inv->jumlah_pack;

            // Menghitung satuan per pack
            $satuanPerPack = $jumlahSatuan / $jumlahPack;

            // Mengurangi satuan berdasarkan jumlah yang diminta
            $sisaSatuan = $jumlahSatuan - $jumlahDiminta;

            // Jika sisa satuan menjadi negatif, artinya jumlah yang diminta melebihi jumlah yang tersedia
            if ($sisaSatuan < 0) {
                return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
            }

            // Mengurangi jumlah pack jika ada pack yang habis terpakai
            if ($jumlahDiminta >= $satuanPerPack) {
                $packTerpakai = floor($jumlahDiminta / $satuanPerPack);
                $jumlahPackBaru = max(0, $jumlahPack - $packTerpakai);
            } else {
                $jumlahPackBaru = $jumlahPack;
            }

            // Perbarui data inventaris dengan jumlah pack dan satuan yang baru
            $inv->update([
                'jumlah_pack' => $jumlahPackBaru,
                'jumlah_satuan' => $sisaSatuan
            ]);
        }

        // Menyimpan data invoice
        $hargaTotal = $request->harga * $request->jumlah;
        $data = new Invoice();
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->invoice_number = $request->kode;
        $jenisBarang = $request->jenis_barang == "Lanyard" ? 'Lanyard' : $request->barang;
        $data->nama_barang = $jenisBarang;
        $data->jumlah_barang = $request->jumlah;
        $data->harga_barang = $request->harga;
        $HargaPass = $request->harga_pas == 1 ? $request->harga : $hargaTotal;
        $data->total_harga = $HargaPass;
        $data->status = 'dp';
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    public function saveBarang(Request $request)
    {   
        // dd($request->all());
        if($request->jenis_barang == 'Lanyard'){
            // dd($request->all());
            // 0 => tali | 1 => stopper | 2 => kail | 3 => kertas
            $getTali = isset($request->lanyard_options[0]) ? $request->lanyard_options[0] * $request->jumlah : 0;
            $getStopper = isset($request->lanyard_options[1]) ? $request->lanyard_options[1] * $request->jumlah : 0;
            $getKail = isset($request->lanyard_options[2]) ? $request->lanyard_options[2] * $request->jumlah : 0;
            $getKertas = isset($request->lanyard_options[3]) ? $request->lanyard_options[3] * $request->jumlah : 0;
            $jenisBarang = $request->jenis_barang;

            // dd($getTali, $getStopper, $getKail, $getKertas);

            $getBarang = Inv::all();
            // dd($getBarang);
            // tali
            $tali = $getBarang->where('nama', 'TALI')->first();
            $jumlahTali = $tali->jumlah_satuan;
            $BijiAsli = $tali->jumlah_satuan_asli;
            
            // STOPPER
            $STOPPER = $getBarang->where('nama', 'STOPPER')->first();
            $jumlahSTOPPER = $STOPPER->jumlah_satuan;
            $BijiAsliStopper = $STOPPER->jumlah_satuan_asli;


            // KERTAS
            $KERTAS = $getBarang->where('nama', 'KERTAS')->first();
            $jumlahKERTAS = $KERTAS->jumlah_satuan;
            $BijiAsliKertas = $KERTAS->jumlah_satuan_asli;

            // STOPPER
            $KAIL = $getBarang->where('nama', 'KAIL')->first();
            $jumlahKAIL = $KAIL->jumlah_satuan;
            $BijiAsliKail = $KAIL->jumlah_satuan_asli;

            // dd($jumlahTali, $jumlahSTOPPER, $jumlahKERTAS, $jumlahKAIL);
            // dd($KAIL, $STOPPER, $KERTAS, $tali);

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKail = $jumlahKAIL - $getKail;
            $sisaKertas = $jumlahKERTAS - $getKertas;

            // dd($sisaTali, $sisaStopper,  $sisaKail, $sisaKertas,);

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
            $penguranganPackTali = $getTali % $BijiAsli;
            $penguranganPackStopper = $getStopper % $BijiAsliStopper;
            $penguranganPackKertas = $getKertas % $BijiAsliKertas;
            $penguranganPackKail = $getKail % $BijiAsliKail;
            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            $SelesihKurangTali = $getTali - $penguranganPackTali;
            $SelesihKurangStopper = $getStopper - $penguranganPackStopper;
            $SelesihKurangKertas = $getKertas - $penguranganPackKertas;
            $SelesihKurangKail = $getKail - $penguranganPackKail;

            // dd($SelesihKurangTali, $SelesihKurangStopper, $SelesihKurangKertas, $SelesihKurangKail);

            // Tali
            if($penguranganPackTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangTali == $BijiAsli){
                    $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_tali = $tali->jumlah_pack;
                }
            }

            // Stopper
            if($penguranganPackStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangStopper == $BijiAsliStopper){
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
                }
            }

            // Kertas
            if($penguranganPackKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKertas == $BijiAsliKertas){
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
                }
            }

            // Kail
            if($penguranganPackKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKail == $BijiAsliKail){
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
                }
            }
            // dd($jumlah_pack_baru_tali, $jumlah_pack_baru_stopper, $jumlah_pack_baru_kertas, $jumlah_pack_baru_kail);

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

        }else if($request->jenis_barang == 'Lanyard + ID Card'){
            // dd($request->all());
            // 0 => tali | 1 => stopper | 2 => kail | 3 => kertas 
            $getTali = isset($request->lanyard_options[0]) ? $request->lanyard_options[0] * $request->jumlah : 0;
            $getStopper = isset($request->lanyard_options[1]) ? $request->lanyard_options[1] * $request->jumlah : 0;
            $getKail = isset($request->lanyard_options[2]) ? $request->lanyard_options[2] * $request->jumlah : 0;
            $getKertas = isset($request->lanyard_options[3]) ? $request->lanyard_options[3] * $request->jumlah : 0;
            $jenisBarang = $request->jenis_barang;

            // dd($getTali, $getStopper, $getKail, $getKertas);

            $getBarang = Inv::all();
            // dd($getBarang);
            // tali
            $tali = $getBarang->where('nama', 'TALI')->first();
            $jumlahTali = $tali->jumlah_satuan;
            $BijiAsli = $tali->jumlah_satuan_asli;
            
            // STOPPER
            $STOPPER = $getBarang->where('nama', 'STOPPER')->first();
            $jumlahSTOPPER = $STOPPER->jumlah_satuan;
            $BijiAsliStopper = $STOPPER->jumlah_satuan_asli;


            // KERTAS
            $KERTAS = $getBarang->where('nama', 'KERTAS')->first();
            $jumlahKERTAS = $KERTAS->jumlah_satuan;
            $BijiAsliKertas = $KERTAS->jumlah_satuan_asli;

            // STOPPER
            $KAIL = $getBarang->where('nama', 'KAIL')->first();
            $jumlahKAIL = $KAIL->jumlah_satuan;
            $BijiAsliKail = $KAIL->jumlah_satuan_asli;

            // ID CARD
            $IDCARD = $getBarang->where('nama', 'ID CARD')->first();
            $jumlahIDCARD = $IDCARD->jumlah_satuan;
            $BijiAsliIDCARD = $IDCARD->jumlah_satuan_asli;


            // dd($jumlahTali, $jumlahSTOPPER, $jumlahKERTAS, $jumlahKAIL);
            // dd($KAIL, $STOPPER, $KERTAS, $tali);

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKail = $jumlahKAIL - $getKail;
            $sisaKertas = $jumlahKERTAS - $getKertas;
            $sisaIDCARD = $jumlahIDCARD - $request->jumlah;

            // dd($sisaTali, $sisaStopper,  $sisaKail, $sisaKertas,);

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
            if($sisaIDCARD <= 5){
                $barangKurang[] = 'ID CARD';
            }

            if(!empty($barangKurang)){
                $barangKurangStr = implode(', ', $barangKurang);
                return redirect()->back()->with('error', 'Barang ' . $barangKurangStr . ' tidak cukup, tambahkan persediaan barang');
            }


            // pengurangan pack 
            $penguranganPackTali = $getTali % $BijiAsli;
            $penguranganPackStopper = $getStopper % $BijiAsliStopper;
            $penguranganPackKertas = $getKertas % $BijiAsliKertas;
            $penguranganPackKail = $getKail % $BijiAsliKail;
            $penguranganPackIDCARD = $request->id_card % $BijiAsliIDCARD;
            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            $SelesihKurangTali = $getTali - $penguranganPackTali;
            $SelesihKurangStopper = $getStopper - $penguranganPackStopper;
            $SelesihKurangKertas = $getKertas - $penguranganPackKertas;
            $SelesihKurangKail = $getKail - $penguranganPackKail;
            $SelisihKurangIDcard = $request->id_card - $penguranganPackIDCARD;

            // dd($SelesihKurangTali, $SelesihKurangStopper, $SelesihKurangKertas, $SelesihKurangKail);

            // Tali
            if($penguranganPackTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangTali == $BijiAsli){
                    $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_tali = $tali->jumlah_pack;
                }
            }

            // ID CARD
            if($penguranganPackIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                if($SelisihKurangIDcard == $BijiAsliIDCARD){
                    $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
                }
            }

            // Stopper
            if($penguranganPackStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangStopper == $BijiAsliStopper){
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
                }
            }

            // Kertas
            if($penguranganPackKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKertas == $BijiAsliKertas){
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
                }
            }

            // Kail
            if($penguranganPackKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKail == $BijiAsliKail){
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
                }
            }
            // dd($jumlah_pack_baru_tali, $jumlah_pack_baru_stopper, $jumlah_pack_baru_kertas, $jumlah_pack_baru_kail);

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
            $updateIDCARD = Inv::where("nama", "ID CARD")->update([
                'jumlah_pack' => $jumlah_pack_baru_IDCard,
                'jumlah_satuan' => $sisaIDCARD
            ]);

        }else if($request->jenis_barang == 'Lanyard + ID Card + Holder'){
            // dd($request->all());
            // 0 => tali | 1 => stopper | 2 => kail | 3 => kertas 
            $getTali = isset($request->lanyard_options[0]) ? $request->lanyard_options[0] * $request->jumlah : 0;
            $getStopper = isset($request->lanyard_options[1]) ? $request->lanyard_options[1] * $request->jumlah : 0;
            $getKail = isset($request->lanyard_options[2]) ? $request->lanyard_options[2] * $request->jumlah : 0;
            $getKertas = isset($request->lanyard_options[3]) ? $request->lanyard_options[3] * $request->jumlah : 0;
            $jenisBarang = $request->jenis_barang;

            // dd($getTali, $getStopper, $getKail, $getKertas);

            $getBarang = Inv::all();
            // dd($getBarang);
            // tali
            $tali = $getBarang->where('nama', 'TALI')->first();
            $jumlahTali = $tali->jumlah_satuan;
            $BijiAsli = $tali->jumlah_satuan_asli;
            
            // STOPPER
            $STOPPER = $getBarang->where('nama', 'STOPPER')->first();
            $jumlahSTOPPER = $STOPPER->jumlah_satuan;
            $BijiAsliStopper = $STOPPER->jumlah_satuan_asli;


            // KERTAS
            $KERTAS = $getBarang->where('nama', 'KERTAS')->first();
            $jumlahKERTAS = $KERTAS->jumlah_satuan;
            $BijiAsliKertas = $KERTAS->jumlah_satuan_asli;

            // STOPPER
            $KAIL = $getBarang->where('nama', 'KAIL')->first();
            $jumlahKAIL = $KAIL->jumlah_satuan;
            $BijiAsliKail = $KAIL->jumlah_satuan_asli;

            // ID CARD
            $IDCARD = $getBarang->where('nama', 'ID CARD')->first();
            $jumlahIDCARD = $IDCARD->jumlah_satuan;
            $BijiAsliIDCARD = $IDCARD->jumlah_satuan_asli;

            $holder = $getBarang->where('nama', 'HOLDER')->first();
            $jumlahHolder = $holder->jumlah_satuan;
            $bijiAsliHolder = $holder->jumlah_satuan_asli;



            // dd($jumlahTali, $jumlahSTOPPER, $jumlahKERTAS, $jumlahKAIL);
            // dd($KAIL, $STOPPER, $KERTAS, $tali);

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKail = $jumlahKAIL - $getKail;
            $sisaKertas = $jumlahKERTAS - $getKertas;
            $sisaIDCARD = $jumlahIDCARD - $request->jumlah;
            $sisaHolder = $jumlahHolder - $request->jumlah;

            // dd($sisaTali, $sisaStopper,  $sisaKail, $sisaKertas,);

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
            if($sisaIDCARD <= 5){
                $barangKurang[] = 'ID CARD';
            }
            if($sisaHolder <= 5){
                $barangKurang[] = 'HOLDER';
            }

            if(!empty($barangKurang)){
                $barangKurangStr = implode(', ', $barangKurang);
                return redirect()->back()->with('error', 'Barang ' . $barangKurangStr . ' tidak cukup, tambahkan persediaan barang');
            }


            // pengurangan pack 
            $penguranganPackTali = $getTali % $BijiAsli;
            $penguranganPackStopper = $getStopper % $BijiAsliStopper;
            $penguranganPackKertas = $getKertas % $BijiAsliKertas;
            $penguranganPackKail = $getKail % $BijiAsliKail;
            $penguranganPackIDCARD = $request->id_card % $BijiAsliIDCARD;
            $penguranganPackHolder = $request->jumlah % $bijiAsliHolder;
            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            $SelesihKurangTali = $getTali - $penguranganPackTali;
            $SelesihKurangStopper = $getStopper - $penguranganPackStopper;
            $SelesihKurangKertas = $getKertas - $penguranganPackKertas;
            $SelesihKurangKail = $getKail - $penguranganPackKail;
            $SelisihKurangIDcard = $request->id_card - $penguranganPackIDCARD;
            $SelisihKurangHolder = $request->jumlah - $penguranganPackHolder;

            // dd($SelesihKurangTali, $SelesihKurangStopper, $SelesihKurangKertas, $SelesihKurangKail);

            // Tali
            if($penguranganPackTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangTali == $BijiAsli){
                    $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_tali = $tali->jumlah_pack;
                }
            }

            // ID CARD
            if($penguranganPackIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                if($SelisihKurangIDcard == $BijiAsliIDCARD){
                    $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
                }
            }

            // holder
            if($penguranganPackHolder == 0){
                $jumlah_pack_baru_holder = $holder->jumlah_pack - 1;
            }else{
                if($SelisihKurangHolder == $bijiAsliHolder){
                    $jumlah_pack_baru_holder = $holder->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_holder = $holder->jumlah_pack;
                }
            }

            // Stopper
            if($penguranganPackStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangStopper == $BijiAsliStopper){
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
                }
            }

            // Kertas
            if($penguranganPackKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKertas == $BijiAsliKertas){
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
                }
            }

            // Kail
            if($penguranganPackKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                // pemblian lebih dari 25 
                if($SelesihKurangKail == $BijiAsliKail){
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
                }else{
                    $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
                }
            }
            // dd($jumlah_pack_baru_tali, $jumlah_pack_baru_stopper, $jumlah_pack_baru_kertas, $jumlah_pack_baru_kail);

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
            $updateIDCARD = Inv::where("nama", "ID CARD")->update([
                'jumlah_pack' => $jumlah_pack_baru_IDCard,
                'jumlah_satuan' => $sisaIDCARD
            ]);

        }else{
            // pengurangan barang non paket
            $inv = Inv::where('nama', $request->barang)->first();
            $a = $request->jumlah;
            $b = $inv->jumlah_pack;
            $c = $inv->jumlah_satuan;
            $BijiAsli = $inv->jumlah_satuan_asli;
            $PackAsli = $inv->jumlah_pack_asli;
            $jenisBarang = $request->jenis_barang;

            // pengurangan satuan
            $sisa = $c - $a;
            // dd($sisa);

            // pengurangan barang
            if( $sisa <= 0){
                return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
            }

            // pengurangan pack
            $penguraganPack = $a % $BijiAsli; // PENGURANGAN 1 PACK LANGSUNG
            $kelipatanBarang = $BijiAsli; // Inisialisasi kelipatan
            $pengali = 1; // Mulai dengan pengali 1
            while ($kelipatanBarang * $pengali <= $sisa) {
                $pengali++; // Tingkatkan pengali
            }

            $kelipatanBarang = $BijiAsli * ($pengali - 1); 

            // dd("masuk : " . $a, "Kelipatan: " . $kelipatanBarang  , " sisa: " . $sisa);

            // dd($penguraganPack);

            // pemblian lebih dari 25 
            if($kelipatanBarang % $sisa == 0 ){
                $jumlah_pack_baru = $b - 1;
                dd("Test 2: ".$jumlah_pack_baru, $sisa, $a);
            }else{
                $jumlah_pack_baru = $b;
                dd("Test 3: ".$jumlah_pack_baru , $sisa, $a);
            }
            
            $inv->update([
                'jumlah_satuan' => $sisa,
                'jumlah_pack' => $jumlah_pack_baru,
            ]);
        }

        
        $harga_total = $request->harga * $request->jumlah;
        $data = new Invoice();
        // data diri pembeli
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;

        // data barang
        $data->invoice_number = 'INV-'.rand(1000, 9999);

        $data->nama_barang = $jenisBarang;
        $data->jumlah_barang = $request->jumlah;
        $data->harga_barang = $request->harga;
        $HargaPass = $request->harga_pas == "on" ? $request->harga : $harga_total;
        $data->total_harga = $HargaPass;
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
