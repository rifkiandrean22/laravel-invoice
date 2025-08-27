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
    Schema::table('chart_of_accounts', function (Blueprint $table) {
        $table->string('type', 50)->change();
    });
}

public function down(): void
{
    Schema::table('chart_of_accounts', function (Blueprint $table) {
        $table->string('type', 5)->change();
    });
}

};
