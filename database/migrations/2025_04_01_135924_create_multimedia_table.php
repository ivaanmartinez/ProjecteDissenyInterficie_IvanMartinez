<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_path');
            $table->string('mime_type');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Afegim el camp user_id com a clau forana
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
