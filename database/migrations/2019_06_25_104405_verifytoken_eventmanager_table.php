<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VerifytokenEventmanagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_managers', function (Blueprint $table) {
            $table->string('verify_token')->nullable()->comment('verify link send when event manager signup');
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
            $table->dropColumn('verify_token');
        });
    }
}
