<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVideosTable extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable(false)->change();
        });
    }
}
