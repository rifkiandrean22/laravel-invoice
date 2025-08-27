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
        Schema::create('items', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique(); // kode barang
    $table->string('name');           // nama barang
    $table->string('category')->nullable(); // kategori (sparepart, BBM, bahan baku)
    $table->string('unit')->default('pcs'); // satuan (pcs, liter, ton)
    $table->integer('stock')->default(0);   // stok awal
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
