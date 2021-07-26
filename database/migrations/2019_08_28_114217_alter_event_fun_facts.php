<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventFunFacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_fun_facts', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('fun_facts')->comment('1 for active and 2 for apeared');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_fun_facts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
