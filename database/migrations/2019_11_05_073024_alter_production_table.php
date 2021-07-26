<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production', function (Blueprint $table) {
            $table->dropColumn('mmround_id');
            $table->bigInteger('chance_id')->unsigned()->after( 'team_id' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production', function (Blueprint $table) {
            $table->dropColumn('chance_id');
            $table->bigInteger('mmround_id')->unsigned()->after( 'team_id' );
        });
    }
}
