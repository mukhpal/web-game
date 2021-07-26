<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMmroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mm_rounds', function (Blueprint $table) {
            $table->dropColumn('chance');
            $table->string('end_time')->after( 'start_time' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mm_rounds', function (Blueprint $table) {
            $table->bigInteger('chance')->unsigned()->after( 'round' );
            $table->dropColumn('end_time');
        });
    }
}
