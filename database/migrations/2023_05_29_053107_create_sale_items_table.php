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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('selling_price');
            $table->integer('qty');
            $table->bigInteger('selling_price_total');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'sale_id'], 'unique_product_sale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
