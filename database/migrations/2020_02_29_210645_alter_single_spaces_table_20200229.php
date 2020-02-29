<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSingleSpacesTable20200229 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panorama_single_spaces', function (Blueprint $table) {
            $table->dropColumn('source_url');
            $table->dropColumn('source_type');
            $table->string('type');
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
            $table->string('source_url');
            $table->string('source_type');
            $table->dropColumn('type');
        });
    }
}
