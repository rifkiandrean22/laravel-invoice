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
        Schema::create('purchase_orders', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_po')->unique();
    $table->unsignedBigInteger('supplier_id')->nullable(); // jika ada tabel suppliers
    $table->date('tanggal_po');
    $table->decimal('total', 15, 2)->default(0);
    $table->string('status')->default('draft'); // draft, approved, completed
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
