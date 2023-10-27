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
        Schema::create('resturants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('cuisine_id')->unsigned();
            $table->foreign('cuisine_id')->references('id')->on('cuisines')->onDelete('cascade');
            $table->text('time_start')->nullable();
            $table->text('time_end')->nullable();
            $table->date('Activation_start');
            $table->date('Activation_end');
            $table->text('name');
            $table->text('description');
            $table->string('phone_number');
            $table->float('deposit')->default('0');
            $table->float('rating')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resturants');
    }
};
