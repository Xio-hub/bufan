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
            $table->string('trade_no');
            $table->string('pay_type',30);
            $table->unsignedInteger('user_id');
            $table->string('username');
            $table->unsignedInteger('course_id');
            $table->decimal('price');
            $table->string('status',100);
            $table->timestamps();

            $table->unique('trade_no');
            $table->index('pay_type');
            $table->index('user_id');
            $table->index('price');
            $table->index('status');
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
