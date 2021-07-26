<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiSuspectInterviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_suspect_interviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('suspect_id');
            $table->text('interview')->nullable();
            $table->integer('status')->defualt(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ci_suspect_interviews');
    }
}
