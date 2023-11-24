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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('introduction');
            $table->string('slug')->unique();
//            $table->text('image');
            $table->integer('weight');
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
            $table->integer('price');
            $table->boolean('status')->default(false);
            $table->boolean('marketable')->default(true);
//            $table->string('tags');
            $table->integer('sold_number', unsigned: true)->default(1);
            $table->integer('frozen_number', unsigned: true)->default(1);
            $table->integer('marketable_number', unsigned: true)->default(1);
            $table->foreignId('brand_id')->constrained('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('category_products')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('published_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
