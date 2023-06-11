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
        Schema::create('customer_return_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('selling_price');
            $table->integer('qty');
            $table->bigInteger('selling_price_total');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_return_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'customer_return_id'], 'unique_customer_return');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_return_items');
    }
};
