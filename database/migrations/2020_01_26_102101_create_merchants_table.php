<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable()->default('');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('merchant_base', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->string('username');
            $table->string('top_logo')->default('');
            $table->string('sitebar_logo')->default('');
            $table->string('slogan')->default('');
            $table->string('category_ids')->default('');
            $table->timestamps();
        });

        Schema::create('merchant_site_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->string('name');
            $table->boolean('is_show')->default(1);
            $table->timestamps();
        });

        Schema::create('introductions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('title');
            $table->text('content')->default('');
            $table->smallInteger('priority')->default(0);
            $table->smallInteger('status')->default(1);
            $table->timestamps();

            $table->index('merchant_id');
            $table->unique(['merchant_id','site_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
        Schema::dropIfExists('merchant_base');
        Schema::dropIfExists('introductions');
    }
}
