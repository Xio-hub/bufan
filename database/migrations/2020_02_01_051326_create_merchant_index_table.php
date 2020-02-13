<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_index', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->string('cover')->default('');
            $table->string('cover_type')->default(''); 
            $table->text('content');
            $table->timestamps();

            $table->unique('merchant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_index');
    }
}
