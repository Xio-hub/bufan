<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->unsignedInteger('course_id');
            $table->string('course_name');
            $table->decimal('price');
            $table->unsignedInteger('user_id');
            $table->string('username');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_orders');
    }
}
