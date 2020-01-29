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
        Schema::create('course_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('backgroung')->nullable()->default('');
            $table->string('introduction')->default('');
            $table->timestamps();
        });

        Schema::create('course_outline', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('course_outline_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('outline_id');
            $table->string('source_url');
            $table->string('source_type');
            $table->timestamps();

            $table->index('outline_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_info');
        Schema::dropIfExists('course_outline');
        Schema::dropIfExists('course_outline_resource');
    }
}
