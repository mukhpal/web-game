<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGamesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image_lnk')->nullable()->after('link');
            $table->string('game_times')->nullable()->after('image_lnk')->comment('game times for email and agenda page');
            $table->string('desc_agenda')->nullable()->after('game_times')->comment('for agenda page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('image_lnk');
            $table->dropColumn('game_times');
            $table->dropColumn('desc_agenda');
        });
    }
}
