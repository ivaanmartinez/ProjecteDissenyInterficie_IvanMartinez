<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Assignar un usuari per defecte (per exemple, el primer usuari existent)
        DB::statement('UPDATE videos SET user_id = (SELECT id FROM users LIMIT 1) WHERE user_id IS NULL;');

        // Un cop assignat, fer la columna `NOT NULL`
        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }


    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

};
