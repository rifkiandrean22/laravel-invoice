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
    Schema::table('invoices', function (Blueprint $table) {
        if (!Schema::hasColumn('invoices', 'payment_note')) {
            $table->string('payment_note')->nullable()->after('status');
        }
        if (!Schema::hasColumn('invoices', 'category')) {
            $table->string('category')->nullable()->after('payment_note');
        }
        if (!Schema::hasColumn('invoices', 'payment_proof')) {
            $table->string('payment_proof')->nullable()->after('category');
        }
        if (!Schema::hasColumn('invoices', 'invoice_number')) {
            $table->string('invoice_number')->nullable()->after('payment_proof');
        }
    });
}

public function down(): void
{
    Schema::table('invoices', function (Blueprint $table) {
        if (Schema::hasColumn('invoices', 'payment_note')) {
            $table->dropColumn('payment_note');
        }
        if (Schema::hasColumn('invoices', 'category')) {
            $table->dropColumn('category');
        }
        if (Schema::hasColumn('invoices', 'payment_proof')) {
            $table->dropColumn('payment_proof');
        }
        if (Schema::hasColumn('invoices', 'invoice_number')) {
            $table->dropColumn('invoice_number');
        }
    });
}

};
