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
        Schema::create('goods_receipts', function (Blueprint $table) {
    $table->id();
    $table->string('gr_number')->unique(); // Nomor GR otomatis
    $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
    $table->date('received_date');
    $table->string('supplier_name');
    $table->string('nama_vendor');
    $table->text('notes')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
