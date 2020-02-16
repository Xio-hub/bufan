<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanoramaSingleSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panorama_single_spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('style_id');
            $table->unsignedInteger('space_id');
            $table->string('source_url');
            $table->timestamps();

            $table->index('merchant_id');
            $table->unique(['material_id','style_id','space_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panorama_single_spaces');
    }
}
