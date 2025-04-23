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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainer_id');
            $table->string('nombre_clase');
            $table->string('categoria');
            $table->integer('capacidad_maxima');
            $table->time('hora_clase');
            $table->date('fecha_clase');
            $table->timestamps();

            $table->foreign('trainer_id')->references('id')->on('trainers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
