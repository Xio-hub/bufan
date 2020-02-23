<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('course_id');
            $table->timestamps();

            $table->index('merchant_id');
            $table->unique('merchant_id','course_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_courses');
    }
}
