<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->string('invoice_number');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->integer('harga_barang');
            $table->integer('total_harga')->nullable();
            $table->integer('total_harga_keseluruhan')->nullable();
            $table->enum('status',['dp','selesai'])->nullable();
            $table->string('uang_dp_lunas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_invoice');
    }
};
