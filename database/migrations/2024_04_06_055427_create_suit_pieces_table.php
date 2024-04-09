<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitPiecesTable extends Migration
{
    public function up()
    {
        Schema::create('suit_pieces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size');
            $table->boolean('available')->default(true);
            // Add other fields as needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suit_pieces');
    }
}
