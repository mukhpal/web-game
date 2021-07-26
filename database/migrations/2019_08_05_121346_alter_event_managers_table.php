<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_managers', function (Blueprint $table) {
            $table->integer('country_id')->nullable()->comment('Manager country');
            $table->integer('state_id')->nullable()->comment('Manager state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_managers', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
        });
    }
}
