<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique( );
            $table->string('name')->unique( );
            $table->text('description')->nullable( false );
            $table->boolean('status')->default( 1 )->comment( '0 => In-active, 1 => Active' );
            $table->timestamp( 'created_at' )->useCurrent( );
            $table->timestamp( 'updated_at' )->useCurrent( );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
