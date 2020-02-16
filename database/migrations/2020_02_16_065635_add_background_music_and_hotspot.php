<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackgroundMusicAndHotspot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('background_music')->nullable()->default('');
            $table->string('hotspot')->nullable()->default('');
        });

        Schema::table('spaces', function (Blueprint $table) {
            $table->string('background_music')->nullable()->default('');
            $table->string('hotspot')->nullable()->default('');
        });

        Schema::table('styles', function (Blueprint $table) {
            $table->string('background_music')->nullable()->default('');
            $table->string('hotspot')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['background_music', 'hotspot']);
        });

        Schema::table('spaces', function (Blueprint $table) {
            $table->dropColumn(['background_music', 'hotspot']);
        });

        Schema::table('styles', function (Blueprint $table) {
            $table->dropColumn(['background_music', 'hotspot']);
        });
    }
}
