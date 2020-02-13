<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseOutlinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_outlines', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title');
			$table->integer('course_id')->unsigned();
			$table->text('content', 65535)->nullable();
			$table->smallInteger('priority')->nullable()->default(0);
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
		Schema::drop('course_outlines');
	}

}
