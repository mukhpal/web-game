<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name', 255);
            $table->text('description');
            $table->string('durations', 255);
            $table->string('image', 255);
            $table->float('price', 8, 2)->default( 0.00 );
            $table->boolean('status')->default( 1 );
            $table->integer('order');
            $table->boolean('deleted')->default( 0 );
            
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
        Schema::dropIfExists('packages');
    }
}
