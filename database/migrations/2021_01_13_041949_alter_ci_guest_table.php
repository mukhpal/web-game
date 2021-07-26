<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCiGuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_guests', function (Blueprint $table) {
            $table->string('fingerprints_img')->nullable()->after('image');
            $table->string('search_house_img')->nullable()->after('fingerprints_img');
            $table->string('search_house_link')->nullable()->after('search_house_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_guests', function (Blueprint $table) {
            $table->dropColumn('fingerprints_img');
            $table->dropColumn('search_house_img');
            $table->dropColumn('search_house_link');
        });
    }
}
