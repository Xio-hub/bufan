<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatabaseIndexToTables20200225 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('merchant_id');
        });

        Schema::table('product_resources', function (Blueprint $table) {
            $table->index('merchant_id');
            $table->index('product_id');
        });

        Schema::table('panoramas', function (Blueprint $table) {
            $table->index(['style_id','material_id']);
        });

        Schema::table('panorama_styles', function (Blueprint $table) {
            $table->index('merchant_id');
        });

        Schema::table('merchant_base', function (Blueprint $table) {
            $table->index('merchant_id');
            $table->index('name');
        });

        Schema::table('index_resources', function (Blueprint $table) {
            $table->index('merchant_id');
            $table->index('index_id');
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
            $table->dropIndex(['merchant_id']);
        });

        Schema::table('product_resources', function (Blueprint $table) {
            $table->dropIndex(['merchant_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('panoramas', function (Blueprint $table) {
            $table->dropIndex(['style_id','material_id']);
        });

        Schema::table('panorama_styles', function (Blueprint $table) {
            $table->dropIndex(['merchant_id']);
        });

        Schema::table('merchant_base', function (Blueprint $table) {
            $table->dropIndex(['merchant_id']);
            $table->dropIndex(['name']);
        });

        Schema::table('index_resources', function (Blueprint $table) {
            $table->dropIndex(['merchant_id']);
            $table->dropIndex(['index_id']);
        });
    }
}
