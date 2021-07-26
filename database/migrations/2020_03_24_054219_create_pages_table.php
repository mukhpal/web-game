<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->string('page_key', 150)->comment('HOME, ABOUT_US, HOW_IT_WORKS, PACKAGES, FAQS, CONTACT_US');
            $table->string('page_title', 255);
            $table->string('page_meta_title', 255)->nullable( true );
            $table->text('page_meta_keywords')->nullable( true );
            $table->text('page_meta_desc')->nullable( true );
            $table->timestamps( );
            $table->primary('page_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
