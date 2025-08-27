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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->string('payment_number')->unique();
        $table->date('payment_date');
        $table->unsignedBigInteger('account_id')->nullable(); // chart_of_accounts
        $table->decimal('amount', 15, 2);
        $table->enum('method', ['cash', 'bank_transfer', 'credit_card', 'other']);
        $table->string('currency')->default('IDR');
        $table->string('status')->default('completed');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
