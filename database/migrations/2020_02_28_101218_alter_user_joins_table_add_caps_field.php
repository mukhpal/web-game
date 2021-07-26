<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserJoinsTableAddCapsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_teams', function (Blueprint $table) {
            $table->string('team_members_cap')->default('1')->after('ib_status')->comment('Caps index for team members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_teams', function (Blueprint $table) {
            $table->dropColumn('team_members_cap');
        });
    }
}
