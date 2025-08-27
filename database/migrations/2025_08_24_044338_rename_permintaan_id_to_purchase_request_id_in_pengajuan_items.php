<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pengajuan_items', function ($table) {
            $table->renameColumn('permintaan_id', 'purchase_request_id');
        });
    }

    public function down(): void {
        Schema::table('pengajuan_items', function ($table) {
            $table->renameColumn('purchase_request_id', 'permintaan_id');
        });
    }
};

