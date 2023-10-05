<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 30)->nullable();
            $table->string('last_name', 30)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile', 11)->unique()->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('national_code', 30)->unique()->nullable();
            $table->timestamp('birth_date')->nullable();
//            $table->string('slug', 60)->unique()->nullable();
            $table->boolean('activation')->default(false)->comment('0 => inActive , 1 => active');
            $table->timestamp('activation_date')->nullable();
//            $table->tinyInteger('user_type')->default(0)->comment('0 => user, 1 => admin');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
