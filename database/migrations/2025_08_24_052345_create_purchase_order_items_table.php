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
        Schema::create('purchase_order_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('purchase_order_id');
    $table->string('nama_item');
    $table->integer('jumlah');
    $table->decimal('harga', 15, 2);
    $table->decimal('total', 15, 2);

    $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
