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
          // images - price_old -   price_new - desc - name - featured - res_id
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resturant_id')->unsigned();
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
            $table->string('price_old')->nullable();
            $table->string('price_new')->nullable();
            $table->string('desc');
            $table->string('name');
            $table->string('type');
            $table->string('open_year')->nullable();
            $table->string('status')->default('active');
            $table->json('featured')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
