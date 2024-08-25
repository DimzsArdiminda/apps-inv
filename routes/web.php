<?php

use App\Http\Controllers\fiturController\keuanganController;
use Illuminate\Support\Facades\Route;

// Routing ketika login
Route::get('/', function () {
    return view('auth.login');
})->name('login2');



// Routing yang dilindungi oleh middleware auth dan verified dari Laravel Breeze
Route::middleware(['auth', 'verified'])->group(function () {

    // Routing ketika berhasil login dan langsung menuju ke halaman dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    // Routing ketika menuju ke halaman inventaris
    Route::get('/dashboard/inventaris', function () {
        return view('inventaris.inventaris');
    })->name('inventaris');

    // Routing ketika menuju ke halaman membuat data inventaris
    Route::get('/dashboard/inventaris/form-barang', function () {
        return view('inventaris.formbarang');
    })->name('form.barang');

    // Routing ketika menuju ke halaman membuat data invoice
    Route::get('/dashboard/invoice/form-invoice', function () {
        return view('invoice.forminvoice');
    })->name('formInvoice');


    include 'fromController.php';
});

require __DIR__.'/auth.php';
