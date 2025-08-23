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
        if (!Schema::hasColumn('invoices', 'total')) {
            $table->decimal('total', 15, 2)->default(0)->after('invoice_number');
        }
    });
}

public function down(): void
{
    Schema::table('invoices', function (Blueprint $table) {
        if (Schema::hasColumn('invoices', 'total')) {
            $table->dropColumn('total');
        }
    });
}

};
