<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeToSourceTypeFromSingleSapcesTabble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('panorama_single_spaces', function (Blueprint $table) {
            $table->renameColumn('type', 'source_type');
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
            $table->renameColumn('source_type', 'type');
        });
    }
}
