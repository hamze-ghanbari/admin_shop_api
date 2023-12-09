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
        Schema::create('color_products', function (Blueprint $table) {
            $table->id();
            $table->string('color_name', 50);
//            $table->string('color')->nullable();
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('price_increase', 20, 3)->default(0);
            $table->boolean('status')->default(false);
            $table->tinyInteger('sold_number')->default(0);
            $table->tinyInteger('frozen_number')->default(0);
            $table->tinyInteger('marketable_number')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_products');
    }
};
