<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_content', function (Blueprint $table) {
            $table->string('pc_page_key', 150)->comment('HOME, ABOUT_US, HOW_IT_WORKS, PACKAGES, FAQS, CONTACT_US');
            $table->string('pc_section_id', 150);
            $table->string('pc_title', 255)->nullable( true );
            $table->string('pc_image', 255)->nullable( true );
            $table->text('pc_description')->nullable( true );
            $table->integer('pc_order');
            $table->timestamps( );
            $table->unique( [ 'pc_page_key', 'pc_section_id' ] );
            $table->foreign('pc_page_key')->references('page_key')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_content');
    }
}
