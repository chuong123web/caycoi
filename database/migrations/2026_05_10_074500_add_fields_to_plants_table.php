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
        Schema::table('plants', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('name_vi')->nullable()->after('name');
            $table->string('slug')->unique()->after('name_vi');
            $table->text('description')->nullable()->after('slug');
            $table->unsignedInteger('price')->default(0)->after('description');
            $table->string('category')->nullable()->after('price');
            $table->string('light')->nullable()->after('category');
            $table->string('tag')->nullable()->after('light');
            $table->text('care_instructions')->nullable()->after('tag');
            $table->boolean('is_active')->default(true)->after('care_instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'name_vi', 'slug', 'description',
                'price', 'category', 'light', 'tag',
                'care_instructions', 'is_active',
            ]);
        });
    }
};
