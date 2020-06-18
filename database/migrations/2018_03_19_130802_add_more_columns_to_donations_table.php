<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('institution_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('session_id')->unsigned()->nullable();

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('session_id')
                ->references('id')->on('sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('institution_id')
                ->references('id')->on('institutions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            //
        });
    }
}
