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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('gift_code_id')->nullable()->constrained('gift_codes')->nullOnDelete()->after('total_amount');
            $table->integer('discount_amount')->default(0)->after('gift_code_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['gift_code_id']);
            $table->dropColumn(['gift_code_id', 'discount_amount']);
        });
    }
};
