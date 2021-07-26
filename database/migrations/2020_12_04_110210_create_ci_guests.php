<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_guests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->string('role')->nullable();
            $table->integer('type')->default('1')->comment('1 for guest and 2 for helper');
            $table->integer('age');
            $table->string('height')->nullable();
            $table->integer('weight');
            $table->string('eye_color')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('ci_guests');
    }
}
