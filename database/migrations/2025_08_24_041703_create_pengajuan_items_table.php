<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengajuan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaan_id'); // foreign key ke tabel permintaan
            $table->string('nama_item');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('permintaan_id')
                  ->references('id')->on('permintaan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengajuan_items');
    }
};

