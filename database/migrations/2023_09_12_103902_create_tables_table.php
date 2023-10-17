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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('resturant_id')->unsigned();
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
          //  $table->string('is_available');
            $table->string('seating_configuration');
            $table->integer('capacity');
            //status(scheduled- current - next) 
            
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
