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
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('resturant_id')->unsigned();
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');

            $table->string('date_start'); 
            $table->string('date_end'); 

            $table->string('sat_from');
            $table->string('sat_to');

            $table->string('sun_from');
            $table->string('sun_to');

            $table->string('mon_from');
            $table->string('mon_to');

            $table->string('tue_from');
            $table->string('tue_to');

            $table->string('wed_from');
            $table->string('wed_to');

            $table->string('thu_from');
            $table->string('thu_to');

            $table->string('fri_from');
            $table->string('fri_to');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};
