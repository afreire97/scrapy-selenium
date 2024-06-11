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
        Schema::create('relojes_viejos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_src');
            $table->decimal('price', 10, 2);
            $table->string('location');
            $table->integer('views');
            $table->string('url');
            $table->string('identificador');
            $table->integer('tipo');
            $table->date('fecha_obtencion');
            $table->foreignId('reloj_vinted_id')->nullable()->constrained('relojes_vinted')->onDelete('cascade');
            $table->foreignId('reloj_wallapop_id')->nullable()->constrained('relojes_wallapop')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relojes_viejos');
    }
};
