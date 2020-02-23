<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceTypeToSingleSpaceTableAndVerticalViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panorama_single_spaces', function (Blueprint $table) {
            $table->string('source_type',50)->default('');
        });

        Schema::table('vertical_views', function (Blueprint $table) {
            $table->string('source_type',50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('panorama_single_spaces', function (Blueprint $table) {
            $table->dropColumn('source_type');
        });

        Schema::table('vertical_views', function (Blueprint $table) {
            $table->dropColumn('source_type');
        });
    }
}
