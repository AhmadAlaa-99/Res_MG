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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resturant_id')->unsigned();
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
            // $table->bigInteger('types_id')->unsigned();
            // $table->foreign('types_id')->references('id')->on('types')->onDelete('cascade');
            $table->string('name');
            $table->string('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
