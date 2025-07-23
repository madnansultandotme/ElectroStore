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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('min_stock')->default(5)->comment('Minimum stock level for alerts');
            $table->integer('max_stock')->default(1000)->comment('Maximum stock level');
            $table->decimal('cost_price', 10, 2)->nullable()->comment('Cost price for profit calculations');
            $table->string('sku')->nullable()->unique()->comment('Stock Keeping Unit');
            $table->string('barcode')->nullable()->comment('Product barcode');
            $table->string('supplier')->nullable()->comment('Supplier information');
            $table->decimal('weight', 8, 2)->nullable()->comment('Product weight in kg');
            $table->json('dimensions')->nullable()->comment('Length, Width, Height in cm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'min_stock', 'max_stock', 'cost_price', 'sku', 
                'barcode', 'supplier', 'weight', 'dimensions'
            ]);
        });
    }
};
