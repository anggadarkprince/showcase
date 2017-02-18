<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portfolio_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->timestamps();

            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_tags');
    }
}
