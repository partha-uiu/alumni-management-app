<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::table('committees', function (Blueprint $table) {

            $table->integer('institution_id')->unsigned();
            $table->integer('department_id')->unsigned();

            $table->foreign('department_id')
                ->references('id')->on('departments')
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
        Schema::table('committees', function (Blueprint $table) {
            //
        });
    }
}
