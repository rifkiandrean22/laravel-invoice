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
    Schema::create('cash_bank_transactions', function (Blueprint $table) {
        $table->id();
        $table->date('transaction_date');
        $table->string('reference')->nullable();
        $table->enum('type', ['cash_in', 'cash_out', 'bank_in', 'bank_out']);
        $table->string('account')->nullable(); // nama bank / kas
        $table->decimal('amount', 15, 2);
        $table->string('currency')->default('IDR');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_bank_transactions');
    }
};
