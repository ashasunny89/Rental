<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('committe_id');
            $table->string('positionname');
            $table->string('name');
            $table->string('image');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('priority'); // Change the data type to string
            $table->timestamps();
            $table->foreign('committe_id')->references('id')->on('committes')->onDelete('cascade');

        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directories');
    }
}
