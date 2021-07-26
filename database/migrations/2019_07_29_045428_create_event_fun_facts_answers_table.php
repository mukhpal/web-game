<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFunFactsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fun_facts_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fun_fact_id')->nullable()->comment('primary key of event_fun_facts table');
            $table->integer('player_id')->nullable()->comment('User who played that game ');
            $table->integer('event_id')->nullable()->comment('current playing event id');
            $table->char('selected_option_userids', 11)->nullable()->comment('options selected by played against fun fact');          
            $table->string('correct_answer', 10)->nullable()->comment('1->correct, 0->Wrong answer');

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
        Schema::dropIfExists('event_fun_facts_answers');
    }
}
