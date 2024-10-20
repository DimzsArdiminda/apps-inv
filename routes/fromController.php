<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\fiturController\notaController;
use App\Http\Controllers\fiturController\keuanganController;
use App\Http\Controllers\fiturController\InventarisController;
use App\Http\Controllers\fiturController\InvoiceController;
use App\Http\Controllers\Auth\PasswordResetController;


// route keuangan
Route::get('/dashboard/anggaran', [keuanganController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/dashboard/anggaran/{bulan}/detail', [keuanganController::class, 'detail'])->middleware(['auth', 'verified'])->name('anggaran.detail');
Route::get('/dashboard/anggaran/chart-data', [keuanganController::class, 'chartData'])->middleware(['auth', 'verified']);
Route::get('/dashboard/anggaran/form-anggaran', [keuanganController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/dashboard/anggaran/store', [keuanganController::class, 'store'])->middleware(['auth', 'verified']);
Route::get('/dashboard/anggaran/edit/{id}', [keuanganController::class, 'edit'])->middleware(['auth', 'verified']);
Route::put('/dashboard/anggaran/update/{id}', [keuanganController::class, 'update'])->middleware(['auth', 'verified']);
Route::delete('/dashboard/anggaran/delete/{id}', [keuanganController::class, 'destroy'])->middleware(['auth', 'verified']);
Route::delete('/dashboard/anggaran/delete/month/{bulan}', [keuanganController::class, 'destroyByMonth'])->name('anggaran.deleteByMonth');
Route::get('/dashboard/anggaran/download/{bulan}', [keuanganController::class, 'downloadExcel'])->name('anggaran.downloadExcel');

// route invoice
Route::get('/api/get/invoice/{kode}', [InvoiceController::class, 'getInvoice'])->name('export.invoice')->middleware(['auth', 'verified']);
Route::post('api/dashboard/transaksi', [InvoiceController::class, 'transaksi'])->name('transaksi')->middleware(['auth', 'verified']);
Route::delete('/api/dashboard/invoice-act-delete/{id}', [InvoiceController::class, 'deleteInvoice'])->name('delete.invoice')->middleware(['auth', 'verified']); // delete invoice
Route::delete('/api/dashboard/item-act-delete/{id}', [InvoiceController::class, 'deleteItem'])->name('delete.item')->middleware(['auth', 'verified']); // delete invoice
Route::get('/dashboard/invoice/detail/tambah/{kodeinv}', [InvoiceController::class, 'tambahBarang'])->name('tambah.barang.invc')->middleware(['auth', 'verified']); // tambah barang
Route::post('api/send-barang', [InvoiceController::class, 'saveBarang'])->name('save.barang')->middleware(['auth', 'verified']);
Route::post('api/send-barang-tambah', [InvoiceController::class, 'saveBarang2'])->name('save.barang.dua')->middleware(['auth', 'verified']);
Route::get('api/get-barang', [InvoiceController::class, 'storeBarang'])->name('select.user')->middleware(['auth', 'verified']);
route::get('/dashboard/invoice/detail/{code}', [InvoiceController::class, 'indexData'])->name('invoiceFull')->middleware(['auth', 'verified']); // get all invoice
Route::get('/dashboard/invoice/', [InvoiceController::class, 'index'])->name('index.invoice')->middleware(['auth', 'verified']); // get all invoice
Route::get('/dashboard/invoice/form-invoice', [InvoiceController::class, 'indexForm'])->name('formInvoice')->middleware(['auth', 'verified']); // get all invoice
Route::get('/dashboard/invoice/form-invoice/{id}', [InvoiceController::class, 'showEdit'])->name('edit.invoice')->middleware(['auth', 'verified']); // get all invoice
Route::post('/dashboard/invoice/form-invoice', [InvoiceController::class, 'saveEditInv'])->name('save.barang.edit')->middleware(['auth', 'verified']); // get all invoice

// Routing ketika lupa password
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::put('/reset-password', [PasswordResetController::class, 'reset'])->name('password.updateByEmail');

//  inventaris
Route::post('api/dashboard/update', [InventarisController::class, 'updatePengurangan'])->name('update.barang.kurang')->middleware(['auth', 'verified']);
Route::get('/dashboard/inventaris/{nama}', [InventarisController::class, 'kurang'])->name('index.kurang.barang')->middleware(['auth', 'verified']);
Route::get('/dashboard/inventaris/', [InventarisController::class, 'index'])->name('index.inven')->middleware(['auth', 'verified']); // get all inventaris
Route::post('/api/dashboard/inventaris-act-create/', [InventarisController::class, 'create'])->name('add.barang')->middleware(['auth', 'verified']); // create inventaris
Route::get('/dashboard/inventaris/edit-barang/{id}', [InventarisController::class, 'indexEdit'])->name('update.barang')->middleware(['auth', 'verified']); // update inventaris
Route::post('/api/dashboard/inventaris-save-update/', [InventarisController::class, 'edit'])->name('save.update')->middleware(['auth', 'verified']); // update inventaris
Route::delete('/api/dashboard/inventaris-act-delete/{id}', [InventarisController::class, 'delete'])->name('delete')->middleware(['auth', 'verified']); // delete inventaris
Route::get('/api/dashboard/inventaris-export/', [InventarisController::class, 'exportInventaris'])->name('export.inven')->middleware(['auth', 'verified']); // export inventaris
Route::get('/dashboard/inventaris/tambah-barang/{id}', [InventarisController::class, 'indexTambahBarang'])->name('index.tambah.barang')->middleware(['auth', 'verified']); // index tambah inventaris
Route::post('/api/dashboard//tambah-barang/act', [InventarisController::class, 'addBarang'])->name('add.kulakan')->middleware(['auth', 'verified']); // tambah inventaris
