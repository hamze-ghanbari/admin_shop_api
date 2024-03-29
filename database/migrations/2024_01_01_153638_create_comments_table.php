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
        Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->text('body');
                $table->foreignId('parent_id')->nullable()->constrained('comments');
                $table->foreignId('user_id')->constrained('users');
                $table->morphs('commentable');
//                $table->unsignedBigInteger('commentable_id');
//                $table->string('commentable_type');
                $table->boolean('seen')->default(false);
                $table->boolean('approved')->default(false);
                $table->boolean('status')->default(false);
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
