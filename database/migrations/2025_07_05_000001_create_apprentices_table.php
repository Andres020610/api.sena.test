<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apprentices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('cell_number');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('computer_id');
            $table->timestamps();

            $table->foreign('computer_id')->references('id')->on('computers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apprentices');
    }
};
