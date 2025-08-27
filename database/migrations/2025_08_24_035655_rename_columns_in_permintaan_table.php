<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan', function (Blueprint $table) {
            $table->renameColumn('nomor_pengajuan', 'nomor_permintaan');
            $table->renameColumn('nama_pengaju', 'nama_permintaan');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan', function (Blueprint $table) {
            $table->renameColumn('nomor_permintaan', 'nomor_pengajuan');
            $table->renameColumn('nama_permintaan', 'nama_pengaju');
        });
    }
};
