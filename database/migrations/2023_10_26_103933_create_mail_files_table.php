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
        Schema::create('mail_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_id')->constrained('mails')->onUpdate('cascade')->onDelete('cascade');
            $table->text('file_path');
            $table->string('file_name', 150)->nullable()->default(null);
            $table->bigInteger('file_size');
            $table->enum('mime_type', [
                'text/csv', 'image/jpeg', 'image/png', 'audio/mpeg',
                'video/mp4', 'application/pdf', 'image/webp', 'application/zip'
            ]);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_files');
    }
};
