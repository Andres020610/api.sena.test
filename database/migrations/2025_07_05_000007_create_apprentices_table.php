<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprenticesTable extends Migration
{
    public function up()
    {
        Schema::create('apprentices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('cell_number');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('computer_id');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('computer_id')->references('id')->on('computers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apprentices');
    }
}
