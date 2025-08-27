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
    Schema::create('chart_of_accounts', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // contoh: 101, 201
        $table->string('name');
        $table->enum('type', ['asset', 'liability', 'equity', 'revenue', 'expense']);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
