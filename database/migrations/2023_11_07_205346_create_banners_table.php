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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('image_path');
            $table->string('url');
//            $table->tinyInteger('position')->default(0)->comment('developer explain 0 or 1 or ... in admin\content\banner model ');
            $table->boolean('status')->default(false);
            $table->timestamp('start_date')->nullable()->useCurrent()->comment('If it is null, the start date is now');
            $table->timestamp('end_date')->nullable()->useCurrent()->comment('If it is null, the end date is Three more days');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
