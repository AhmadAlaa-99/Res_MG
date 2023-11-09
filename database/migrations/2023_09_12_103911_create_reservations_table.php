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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
       
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            
            $table->bigInteger('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
            
            $table->bigInteger('resturant_id')->unsigned();
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
            
            $table->string('speacial_request')->nullable();
            $table->string('actual_price')->nullable();
            $table->string('reservation_time'); //(9\12\2023 4:32 PM)
            $table->string('reservation_time_end')->nullable(); //(9\12\2023 4:32 PM)

            $table->string('duration')->nullable(); //(9\12\2023 4:32 PM)

            $table->date('reservation_date'); //(9\12\2023 4:32 PM)
            $table->string('party_size')->nullable();
            $table->string('status')->default('scheduled');   //status(scheduled - current - next) 

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
