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
        Schema::create('procurement_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('capital_price');
            $table->integer('qty');
            $table->bigInteger('capital_price_total');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('procurement_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'procurement_id'], 'unique_product_procurement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_items');
    }
};
