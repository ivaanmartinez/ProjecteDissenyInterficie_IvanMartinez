<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('title');
            $table->text('description');
            $table->string('image'); // pot ser un path o una URL
            $table->string('user_name');
            $table->string('user_photo_url')->nullable(); // per si no té foto
            $table->timestamp('published_at')->nullable(); // potser no sempre està publicada d'entrada
            $table->timestamps(); // created_at i updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
