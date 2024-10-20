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
    public function saveEditInv(Request $request){
        
        $getJumlahTambah = $request->jumlah_barang; // Barang yang ditambahkan
        $getJumlahPengurangan = $request->jumlah_barang_baru; // Barang yang diambil
        $getHarga = $request->harga_barang;
       
        
        if($request->nama_barang === "Lanyard"){
            // Tali
            $getTali = Inv::where('nama', 'TALI')->first();
            $getTotalBarangTali = $getTali->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganTali = $getTotalBarangTali - $getJumlahPengurangan;

            // Cek apakah stok mencukupi untuk pengambilan barang Tali
            if ($stokSetelahPenguranganTali < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Tali)');
            }

            // Update jumlah dan harga barang pada tabel invoice
            $harga_total = $request->harga_barang * $getJumlahPengurangan;
            $HargaPass = $request->harga_barang == "on" ? $request->harga_barang : $harga_total;

            $data = Invoice::where('id', $request->id)->first();
            $data->jumlah_barang = $getJumlahPengurangan;
            $data->harga_barang = $request->harga_barang;
            $data->total_harga = $HargaPass;
            $data->update();

            // Kurangi stok Tali
            $getTali->update([
                'jumlah_satuan' => $stokSetelahPenguranganTali
            ]);

            // Stopper
            $getStopper = Inv::where('nama', 'STOPPER')->first();
            $getTotalBarangStopper = $getStopper->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganStopper = $getTotalBarangStopper - $getJumlahPengurangan;

            if ($stokSetelahPenguranganStopper < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Stopper)');
            }

            // Kurangi stok Stopper
            $getStopper->update([
                'jumlah_satuan' => $stokSetelahPenguranganStopper
            ]);

            // Kail
            $getKail = Inv::where('nama', 'KAIL')->first();
            $getTotalBarangKail = $getKail->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKail = $getTotalBarangKail - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKail < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kail)');
            }

            // Kurangi stok Kail
            $getKail->update([
                'jumlah_satuan' => $stokSetelahPenguranganKail
            ]);

            // Kertas
            $getKertas = Inv::where('nama', 'KERTAS')->first();
            $getTotalBarangKertas = $getKertas->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKertas = $getTotalBarangKertas - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKertas < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kertas)');
            }

            // Kurangi stok Kertas
            $getKertas->update([
                'jumlah_satuan' => $stokSetelahPenguranganKertas
            ]);

            // Setelah semua stok diperbarui dan dicek, lanjutkan logika bisnis lainnya
            return redirect()->back()->with('success', 'Stok dan invoice berhasil diperbarui');


        }elseif($request->nama_barang === 'Lanyard + ID Card'){

            // Tali
            $getTali = Inv::where('nama', 'TALI')->first();
            $getTotalBarangTali = $getTali->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganTali = $getTotalBarangTali - $getJumlahPengurangan;

            // Cek apakah stok mencukupi untuk pengambilan barang Tali
            if ($stokSetelahPenguranganTali < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Tali)');
            }

            // Update jumlah dan harga barang pada tabel invoice
            $harga_total = $request->harga_barang * $getJumlahPengurangan;
            $HargaPass = $request->harga_barang == "on" ? $request->harga_barang : $harga_total;

            $data = Invoice::where('id', $request->id)->first();
            $data->jumlah_barang = $getJumlahPengurangan;
            $data->harga_barang = $request->harga_barang;
            $data->total_harga = $HargaPass;
            $data->update();

            // Kurangi stok Tali
            $getTali->update([
                'jumlah_satuan' => $stokSetelahPenguranganTali
            ]);

            // Stopper
            $getStopper = Inv::where('nama', 'STOPPER')->first();
            $getTotalBarangStopper = $getStopper->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganStopper = $getTotalBarangStopper - $getJumlahPengurangan;

            if ($stokSetelahPenguranganStopper < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Stopper)');
            }

            // Kurangi stok Stopper
            $getStopper->update([
                'jumlah_satuan' => $stokSetelahPenguranganStopper
            ]);

            // Kail
            $getKail = Inv::where('nama', 'KAIL')->first();
            $getTotalBarangKail = $getKail->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKail = $getTotalBarangKail - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKail < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kail)');
            }

            // Kurangi stok Kail
            $getKail->update([
                'jumlah_satuan' => $stokSetelahPenguranganKail
            ]);

            // Kertas
            $getKertas = Inv::where('nama', 'KERTAS')->first();
            $getTotalBarangKertas = $getKertas->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKertas = $getTotalBarangKertas - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKertas < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kertas)');
            }

            // Kurangi stok Kertas
            $getKertas->update([
                'jumlah_satuan' => $stokSetelahPenguranganKertas
            ]);

            // ID Card
            $getIDCARD = Inv::where('nama', 'ID CARD')->first();
            $getTotalBarangIDCard = $getIDCARD->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganIDCard = $getTotalBarangIDCard - $getJumlahPengurangan;

            if ($stokSetelahPenguranganIDCard < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (ID CARD)');
            }

            // Kurangi stok ID Card
            $getIDCARD->update([
                'jumlah_satuan' => $stokSetelahPenguranganIDCard
            ]);

            // Holder
            $getHolder = Inv::where('nama', 'HOLDER')->first();
            $getTotalBarangHolder = $getHolder->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganHolder = $getTotalBarangHolder - $getJumlahPengurangan;

            if ($stokSetelahPenguranganHolder < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Holder)');
            }

            // Kurangi stok Holder
            $getHolder->update([
                'jumlah_satuan' => $stokSetelahPenguranganHolder
            ]);


        }elseif($request->nama_barang === 'Lanyard + ID Card + Holder'){

            // Tali
            $getTali = Inv::where('nama', 'TALI')->first();
            $getTotalBarangTali = $getTali->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganTali = $getTotalBarangTali - $getJumlahPengurangan;

            // Cek apakah stok mencukupi untuk pengambilan barang Tali
            if ($stokSetelahPenguranganTali < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Tali)');
            }

            // Update jumlah dan harga barang pada tabel invoice
            $harga_total = $request->harga_barang * $getJumlahPengurangan;
            $HargaPass = $request->harga_barang == "on" ? $request->harga_barang : $harga_total;

            $data = Invoice::where('id', $request->id)->first();
            $data->jumlah_barang = $getJumlahPengurangan;
            $data->harga_barang = $request->harga_barang;
            $data->total_harga = $HargaPass;
            $data->update();

            // Kurangi stok Tali
            $getTali->update([
                'jumlah_satuan' => $stokSetelahPenguranganTali
            ]);

            // Stopper
            $getStopper = Inv::where('nama', 'STOPPER')->first();
            $getTotalBarangStopper = $getStopper->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganStopper = $getTotalBarangStopper - $getJumlahPengurangan;

            if ($stokSetelahPenguranganStopper < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Stopper)');
            }

            // Kurangi stok Stopper
            $getStopper->update([
                'jumlah_satuan' => $stokSetelahPenguranganStopper
            ]);

            // Kail
            $getKail = Inv::where('nama', 'KAIL')->first();
            $getTotalBarangKail = $getKail->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKail = $getTotalBarangKail - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKail < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kail)');
            }

            // Kurangi stok Kail
            $getKail->update([
                'jumlah_satuan' => $stokSetelahPenguranganKail
            ]);

            // Kertas
            $getKertas = Inv::where('nama', 'KERTAS')->first();
            $getTotalBarangKertas = $getKertas->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganKertas = $getTotalBarangKertas - $getJumlahPengurangan;

            if ($stokSetelahPenguranganKertas < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Kertas)');
            }

            // Kurangi stok Kertas
            $getKertas->update([
                'jumlah_satuan' => $stokSetelahPenguranganKertas
            ]);

            // ID Card
            $getIDCARD = Inv::where('nama', 'ID CARD')->first();
            $getTotalBarangIDCard = $getIDCARD->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganIDCard = $getTotalBarangIDCard - $getJumlahPengurangan;

            if ($stokSetelahPenguranganIDCard < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (ID CARD)');
            }

            // Kurangi stok ID Card
            $getIDCARD->update([
                'jumlah_satuan' => $stokSetelahPenguranganIDCard
            ]);

            // Holder
            $getHolder = Inv::where('nama', 'HOLDER')->first();
            $getTotalBarangHolder = $getHolder->jumlah_satuan + $getJumlahTambah;
            $stokSetelahPenguranganHolder = $getTotalBarangHolder - $getJumlahPengurangan;

            if ($stokSetelahPenguranganHolder < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup (Holder)');
            }

            // Kurangi stok Holder
            $getHolder->update([
                'jumlah_satuan' => $stokSetelahPenguranganHolder
            ]);

        }else{

            // Ambil stok barang saat ini berdasarkan nama barang
            $getJumlahBarang = Inv::where('nama', $request->nama_barang)->first();
            // dd($getJumlahBarang);
            // dd($request->all());

            // Tambahkan jumlah barang yang baru ditambahkan ke stok saat ini
            $getTotalBarang = $getJumlahBarang->jumlah_satuan + $getJumlahTambah;
            // dd($getJumlahTambah);
            // dd($getTotalBarang);
                        
            // Pengurangan stok sesuai dengan jumlah barang yang diambil
            $stokSetelahPengurangan =  $getTotalBarang - $getJumlahPengurangan;
            // dd($stokSetelahPengurangan);


            // Cek apakah stok mencukupi untuk pengambilan barang
            if ($stokSetelahPengurangan < 5) {
                return redirect()->back()->with('error', 'Barang tidak cukup');
            }



            $harga_total = $request->harga_barang * $getJumlahPengurangan;
            $HargaPass = $request->harga_barang == "on" ? $request->harga_barang : $harga_total ;

            // dd($HargaPass);
            // update tabel invoice
            $data = Invoice::where('id', $request->id)->first();
            // dd($data);
            $data->jumlah_barang = $getJumlahPengurangan;
            $data->harga_barang = $request->harga_barang;
            $data->total_harga = $HargaPass;
            // Kurangi stok barang sesuai pengambilan
            $getJumlahBarang->update([
                'jumlah_satuan' => $stokSetelahPengurangan
            ]);
            $data->update();
        }
        

        // Masukan ke tabel pemasukan 
        $data = new pemasukan_pengeluaran();
        $data->tanggal = date('Y-m-d');
        $data->jenis = 'pemasukan';
        $data->jumlah = $request->harga_barang;
        $data->keterangan = 'Update Pemasukan dari penjualan barang '. $request->nama_barang . ' dengan kode invoice '. $request->kode ;
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
    public function showEdit($id)
    {
        // dd($id);
        $data = Invoice::where('id', $id)->first();
        // dd($data);
        return view('invoice.edit', ['data' => $data]);
    }
    public function getInvoice($kode)
    {
        // Ambil semua data invoice berdasarkan nomor invoice
        $data = Invoice::where('invoice_number', $kode)->get();

        // Cek apakah data ditemukan
        if ($data->isEmpty()) {
            return redirect()->back()->withErrors('Invoice not found.');
        }

        // Perhitungan total dan status pembayaran
        $grand_total = $data->sum('total_harga');
        $total_dibayar = $data->sum('uang_dp_lunas');
        $total_sisa = $grand_total - $total_dibayar;

        // Proses data yang akan dikirim ke view
        $invoiceData = [
            'data' => $data,
            'grand_total' => $grand_total,
            'total_dibayar' => $total_dibayar,
            'total_sisa' => $total_sisa,
        ];

        // Ukuran kertas: lebar 15 cm dan tinggi 20 cm
        // $customPaper = [0, 0, 150, 200]; // width = 150 mm, height = 200 mm

        // Aktifkan remote file untuk gambar
        $pdf = PDF::loadView('invoice.invoiceFull.invoicefull', $invoiceData)
            // ->setPaper($customPaper, 'landscape'); // Mengatur ukuran kertas
            ->setPaper('b5', 'landscape'); // Mengatur ukuran kertas

        // Unduh PDF
        return $pdf->download($data[0]->invoice_number . '.pdf');
    }

    


    
    
    public function transaksi(Request $req){
        // dd($req->all());
        $getData = Invoice::where('invoice_number', $req->kode)->first();
        $dataUang = $getData->uang_dp_lunas == null ? 0 : $getData->uang_dp_lunas;
        // dd($dataUang);

        
        if ($getData) {
            $getData->total_harga_keseluruhan = $req->total;
            $getData->status = $req->status;
            $getData->uang_dp_lunas = $req->uang_diterima + $dataUang;
            // dd($getData->uang_dp_lunas);
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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }
            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
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
            $getIDCARD = $request->id_card;
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
            // dd($getIDCARD);
            $IDCARD = $getBarang->where('nama',"ID CARD")->first();
            $jumlahIDCARD = $IDCARD->jumlah_satuan;
            $BijiAsliIDCARD = $IDCARD->jumlah_satuan_asli;


            // dd($jumlahTali, $jumlahSTOPPER, $jumlahKERTAS, $jumlahKAIL);
            // dd($KAIL, $STOPPER, $KERTAS, $tali);

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKail = $jumlahKAIL - $getKail;
            $sisaKertas = $jumlahKERTAS - $getKertas;
            if($request->id_card == "ID CARD 2"){
                // $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 2;
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 1;
            }else{
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah;
            }

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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }

            $penguranganPackIDCARD = $BijiAsliIDCARD;
            $pengaliIDCARD = 1;
            while($penguranganPackIDCARD * $pengaliIDCARD <= $sisaIDCARD){
                $pengaliIDCARD++;
            }

            // dd($SelesihKurangTali, $SelesihKurangStopper, $SelesihKurangKertas, $SelesihKurangKail);

            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
            }

            // ID CARD
            if($penguranganPackIDCARD % $sisaIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
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
            if($request->id_card == "ID CARD 2"){
                // $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 2;
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 1;
            }else{
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah;
            }
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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }

            $penguranganPackIDCARD = $BijiAsliIDCARD;
            $pengaliIDCARD = 1;
            while($penguranganPackIDCARD * $pengaliIDCARD <= $sisaIDCARD){
                $pengaliIDCARD++;
            }

            $penguranganPackHolder = $bijiAsliHolder;
            $pengaliHolder = 1;
            while($penguranganPackHolder * $pengaliHolder <= $sisaHolder){
                $pengaliHolder++;
            }

            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            
            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
            }

            // ID CARD
            if($penguranganPackIDCARD % $sisaIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
            }

            // Holder
            if($penguranganPackHolder % $sisaHolder == 0){
                $jumlah_pack_baru_Holder = $holder->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_Holder = $holder->jumlah_pack;
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
            $updateHolder = Inv::where("nama", "HOLDER")->update([
                'jumlah_pack' => $jumlah_pack_baru_Holder,
                'jumlah_satuan' => $sisaHolder
            ]);

        }else{
           // pengurangan barang non paket
            $inv = Inv::where('nama', $request->barang)->first();
            $a = $request->jumlah;
            $b = $inv->jumlah_pack;
            $c = $inv->jumlah_satuan;
            $BijiAsli = $inv->jumlah_satuan_asli;
            $PackAsli = $inv->jumlah_pack_asli;
            $jenisBarang = $request->barang;

            // pengurangan satuan
            $sisa = $c - $a;
            // dd($sisa);

            // pengurangan barang
            if( $sisa <= 0){
                return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
            }

            // pengurangan pack
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
                // dd("Test 2: ".$jumlah_pack_baru, $sisa, $a);
            }else{
                $jumlah_pack_baru = $b;
                // dd("Test 3: ".$jumlah_pack_baru , $sisa, $a);
            }

            $inv->update([
                'jumlah_satuan' => $sisa,
                'jumlah_pack' => $jumlah_pack_baru,
            ]);
        }

        // Menyimpan data invoice
        // dd($request->all());
        $harga_total = $request->harga * $request->jumlah;
        $data = new Invoice();
        // data diri pembeli
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;

        $data->invoice_number = $request->kode;

        $data->nama_barang = $jenisBarang;
        $data->jumlah_barang = $request->jumlah;
        $data->harga_barang = $request->harga;
        // jika harga_pass on maka harga yang diambil adalah harga yang diinputkan
        $HargaPass = $request->harga_pas == "on" ? $request->harga : $harga_total;
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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }
            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
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
            $getIDCARD = $request->id_card;
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
            // dd($getIDCARD);
            $IDCARD = $getBarang->where('nama',"ID CARD")->first();
            $jumlahIDCARD = $IDCARD->jumlah_satuan;
            $BijiAsliIDCARD = $IDCARD->jumlah_satuan_asli;


            // dd($jumlahTali, $jumlahSTOPPER, $jumlahKERTAS, $jumlahKAIL);
            // dd($KAIL, $STOPPER, $KERTAS, $tali);

            // pengurangan barang
            $sisaTali = $jumlahTali - $getTali;
            $sisaStopper = $jumlahSTOPPER - $getStopper;
            $sisaKail = $jumlahKAIL - $getKail;
            $sisaKertas = $jumlahKERTAS - $getKertas;
            if($request->id_card == "ID CARD 2"){
                // $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 2;
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 1;
            }else{
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah;
            }

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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }

            $penguranganPackIDCARD = $BijiAsliIDCARD;
            $pengaliIDCARD = 1;
            while($penguranganPackIDCARD * $pengaliIDCARD <= $sisaIDCARD){
                $pengaliIDCARD++;
            }

            // dd($SelesihKurangTali, $SelesihKurangStopper, $SelesihKurangKertas, $SelesihKurangKail);

            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
            }

            // ID CARD
            if($penguranganPackIDCARD % $sisaIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
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
            if($request->id_card == "ID CARD 2"){
                // $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 2;
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah * 1;
            }else{
                $sisaIDCARD = $jumlahIDCARD - $request->jumlah;
            }
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
            // tali
            $penguranganPackTali =  $BijiAsli;
            $pengaliTali = 1;
            while($penguranganPackTali * $pengaliTali <= $sisaTali){
                $pengaliTali++;
            }

            // stopper
            $penguranganPackStopper = $BijiAsliStopper;
            $pengaliStopper = 1;
            while($penguranganPackStopper * $pengaliStopper <= $sisaStopper){
                $pengaliStopper++;
            }

            // kertas
            $penguranganPackKertas = $BijiAsliKertas;
            $pengaliKertas = 1;
            while($penguranganPackKertas * $pengaliKertas <= $sisaKertas){
                $pengaliKertas++;
            }

            $penguranganPackKail = $BijiAsliKail;
            $pengaliKail = 1;
            while($penguranganPackKail * $pengaliKail <= $sisaKail){
                $pengaliKail++;
            }

            $penguranganPackIDCARD = $BijiAsliIDCARD;
            $pengaliIDCARD = 1;
            while($penguranganPackIDCARD * $pengaliIDCARD <= $sisaIDCARD){
                $pengaliIDCARD++;
            }

            $penguranganPackHolder = $bijiAsliHolder;
            $pengaliHolder = 1;
            while($penguranganPackHolder * $pengaliHolder <= $sisaHolder){
                $pengaliHolder++;
            }

            // dd($penguranganPackTali, $penguranganPackStopper, $penguranganPackKertas, $penguranganPackKail);

            
            // Tali
            if($penguranganPackTali % $sisaTali == 0){
                $jumlah_pack_baru_tali = $tali->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_tali = $tali->jumlah_pack;
            }

            // Stopper
            if($penguranganPackStopper % $sisaStopper == 0){
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_stopper = $STOPPER->jumlah_pack;
            }


            // Kertas
            if($penguranganPackKertas % $sisaKertas == 0){
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kertas = $KERTAS->jumlah_pack;
            }

            // Kail
            if($penguranganPackKail % $sisaKail == 0){
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_kail = $KAIL->jumlah_pack;
            }

            // ID CARD
            if($penguranganPackIDCARD % $sisaIDCARD == 0){
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_IDCard = $IDCARD->jumlah_pack;
            }

            // Holder
            if($penguranganPackHolder % $sisaHolder == 0){
                $jumlah_pack_baru_Holder = $holder->jumlah_pack - 1;
            }else{
                $jumlah_pack_baru_Holder = $holder->jumlah_pack;
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
            $updateHolder = Inv::where("nama", "HOLDER")->update([
                'jumlah_pack' => $jumlah_pack_baru_Holder,
                'jumlah_satuan' => $sisaHolder
            ]);

        }else{
            // dd($request->all());
            // pengurangan barang non paket
            $inv = Inv::where('nama', $request->barang)->first();
            $a = $request->jumlah;
            $b = $inv->jumlah_pack;
            $c = $inv->jumlah_satuan;
            $BijiAsli = $inv->jumlah_satuan_asli;
            $PackAsli = $inv->jumlah_pack_asli;
            $jenisBarang = $request->barang;

            // pengurangan satuan
            $sisa = $c - $a;
            // dd($sisa);

            // pengurangan barang
            if( $sisa <= 0){
                return redirect()->back()->with('error','Barang tidak cukup, tambahkan persediaan barang');
            }

            // pengurangan pack
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
                // dd("Test 2: ".$jumlah_pack_baru, $sisa, $a);
            }else{
                $jumlah_pack_baru = $b;
                // dd("Test 3: ".$jumlah_pack_baru , $sisa, $a);
            }

            $inv->update([
                'jumlah_satuan' => $sisa,
                'jumlah_pack' => $jumlah_pack_baru,
            ]);
        }

        // dd($request->all());
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
        // jika harga_pass on maka harga yang diambil adalah harga yang diinputkan
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
        $getData = Invoice::selectRaw('ANY_VALUE(nama) as nama, invoice_number, ANY_VALUE(status) as status')
            ->groupBy('invoice_number')
            ->orderBy('status')
            ->get();
            
        return view('invoice.index', ['data' => $getData]);
    }
    public function indexData($getID){
        // dd($getID);
        $getData =  Invoice::where('invoice_number', $getID)->get();
        // total semua harga berdasarkan kode invoice
        $total = Invoice::where('invoice_number', $getID)->sum('total_harga');
        $getKode = $getData->first()->invoice_number;
        $uang = $getData->first()->uang_dp_lunas;
        $sisa = $total - $uang;
        $status = $getData->first()->status;
        // dd($getData);
        return view('invoice.invoice', ['data' => $getData, 'total' => $total, 'uang' => $uang, 'sisa' => $sisa, 'status' => $status, 'kode' => $getKode]);
   }
}
