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
        Schema::create('relojes_vinted', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_src');
            $table->decimal('price', 10, 2);
            $table->string('brand');
            $table->string('location');
            $table->integer('views');
            $table->string('url');
            $table->string('identificador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relojes_vinted');
    }
};
