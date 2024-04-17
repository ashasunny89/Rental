<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalTable extends Migration
{
    public function up()
    {
  
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->date('rental_date');
            $table->date('return_date');
            $table->decimal('advanced_amount', 10, 2);
            $table->decimal('total_rent', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentals');
    }
    

    
}
