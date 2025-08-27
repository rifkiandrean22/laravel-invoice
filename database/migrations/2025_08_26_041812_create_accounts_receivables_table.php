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
    Schema::create('accounts_receivables', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('customer_id')->nullable();
        $table->string('invoice_number')->unique();
        $table->date('invoice_date');
        $table->date('due_date')->nullable();
        $table->decimal('amount', 15, 2);
        $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_receivables');
    }
};
