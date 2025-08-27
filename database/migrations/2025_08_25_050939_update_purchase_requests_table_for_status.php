<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('status');

            // Hapus kolom lama jika ada
            if (Schema::hasColumn('purchase_requests', 'approved_by')) {
                $table->dropColumn('approved_by');
            }
            if (Schema::hasColumn('purchase_requests', 'rejected_by')) {
                $table->dropColumn('rejected_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            // Rollback: hapus status & reviewed_by
            $table->dropColumn(['status', 'reviewed_by']);

            // Balikin lagi kolom lama
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
        });
    }
};
