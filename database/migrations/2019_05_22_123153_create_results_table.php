<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voter_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->integer('nominee_id')->unsigned();
            $table->integer('election_id')->unsigned();
            $table->timestamps();

            // $table->foreign('election_id')
            //       ->references('id')
            //       ->on('election')
            //       ->onDelete('cascade');

            // $table->foreign('position_id')
            //       ->references('id')
            //       ->on('position')
            //       ->onDelete('cascade');                      

            // $table->foreign('voter_id')
            //       ->references('id')
            //       ->on('voter')
            //       ->onDelete('cascade');

            // $table->foreign('nominee_id')
            //       ->references('id')
            //       ->on('nominee')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
