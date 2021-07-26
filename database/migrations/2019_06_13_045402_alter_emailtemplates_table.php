<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmailtemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emailtemplates', function (Blueprint $table) {
            $table->string('email_slug')->nullable()->comment('created slug to get particular email template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emailtemplates', function (Blueprint $table) {
            $table->dropColumn('email_slug');
        });
    }
}
