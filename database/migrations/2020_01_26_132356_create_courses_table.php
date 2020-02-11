<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('background')->nullable()->default('');
            $table->text('introduction')->default('');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
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
        Schema::dropIfExists('course_config');
        Schema::dropIfExists('courses');
    }
}
