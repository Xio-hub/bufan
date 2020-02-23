<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMusicToMerchantIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_index', function (Blueprint $table) {
            $table->string('music1')->default('');
            $table->string('music2')->default('');
            $table->string('music3')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_index', function (Blueprint $table) {
            $table->dropColumn('music1');
            $table->dropColumn('music2');
            $table->dropColumn('music3');
        });
    }
}
