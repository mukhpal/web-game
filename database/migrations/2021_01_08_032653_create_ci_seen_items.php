<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiSeenItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_seen_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('team_id');
            $table->integer('event_id');
            $table->integer('item_id')->comment("1->interview, 2->mansion, 3 -> firnger prints, 
                                        4->gloves, 5-> security pics, 6-> party pics, 7-> police reports, 
                                        8->thief search, 9-> mansion search, 10->lamp, 11->first ques, 12->second ques, 13->3rd ques");
            $table->string('item_name')->comment("particular item to display");
            $table->integer('action')->comment("1->interview, 2->mansion, 3-> finger prints, 
                                        4->search house, 5->DMV search, 6->question, 7->police report, 8->hint unlock");
            $table->integer('suspect_id');
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
        Schema::dropIfExists('ci_seen_items');
    }
}
