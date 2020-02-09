<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('space_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->string('name');
            $table->string('cover')->default('');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
        });

        Schema::create('spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedMediumInteger('category_id');
            $table->string('name');
            $table->string('cover');
            $table->string('type');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('category_id');
        });

        Schema::create('space_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedMediumInteger('space_id');
            $table->string('source_url');
            $table->string('source_type');
            $table->smallInteger('priority')->default(0);
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('space_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('space_categories');
        Schema::dropIfExists('spaces');
        Schema::dropIfExists('space_resources');
    }
}
