<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_payables', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('vendor_name');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('payment_date')->nullable();
            $table->text('payment_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts_payables');
    }
};
