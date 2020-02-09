<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('style_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->string('name');
            $table->string('cover');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
        });

        Schema::create('styles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->string('cover');
            $table->string('type');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('category_id');
        });

        Schema::create('style_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedMediumInteger('style_id');
            $table->string('source_url');
            $table->string('source_type');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('style_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('style_categories');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('style_resources');
    }
}
