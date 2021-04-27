<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('election_id')
                  ->references('id')
                  ->on('elections')
                  ->onDelete('cascade');

            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions')
                  ->onDelete('cascade');                      

            $table->foreign('voter_id')
                  ->references('id')
                  ->on('voters')
                  ->onDelete('cascade');

            $table->foreign('nominee_id')
                  ->references('id')
                  ->on('nominees')
                  ->onDelete('cascade');
        }); 

        Schema::table('slots', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');
        }); 

        Schema::table('nominee_slot', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('slot_id')
                ->references('id')
                ->on('slots')
                ->onDelete('cascade');

            $table->foreign('nominee_id')
                ->references('id')
                ->on('nominees')
                ->onDelete('cascade');
        }); 

        Schema::table('election_slot', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('slot_id')
                ->references('id')
                ->on('slots')
                ->onDelete('cascade');

            $table->foreign('election_id')
                ->references('id')
                ->on('elections')
                ->onDelete('cascade');
        }); 

        Schema::table('signatures', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('election_id')
                ->references('id')
                ->on('elections')
                ->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign(
                ['election_id', 'position_id', 'voter_id', 'nominee_id']
            );
        });

        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
        });

        Schema::table('nominee_slot', function (Blueprint $table) {
            $table->dropForeign(['slot_id', 'nominee_id']);
        });

        Schema::table('election_slot', function (Blueprint $table) {
            $table->dropForeign(['slot_id', 'election_id']);
        });

        Schema::table('signatures', function (Blueprint $table) {
            $table->dropForeign(['election_id']);
        });
    }
}
