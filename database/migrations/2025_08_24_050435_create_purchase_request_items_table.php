<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
    $table->engine = 'InnoDB';
    $table->id();
    $table->unsignedBigInteger('purchase_request_id');
    $table->string('nama_item');
    $table->integer('jumlah');
    $table->decimal('harga', 15, 2);
    $table->decimal('total', 15, 2)->default(0);
    $table->timestamps();

    $table->foreign('purchase_request_id')
          ->references('id')
          ->on('purchase_requests')
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};

