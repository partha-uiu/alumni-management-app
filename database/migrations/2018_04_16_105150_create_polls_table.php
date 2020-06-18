<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('max_checkable');
            $table->integer('institution_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('session_id')->unsigned()->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('end_date');
            $table->tinyInteger('is_approved')->default(1);
            $table->integer('edited_by')->unsigned()->nullable();
            $table->string('edit_time')->nullable();
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('session_id')
                ->references('id')->on('sessions')
                ->onDelete('SET NULL')
                ->onUpdate('cascade');

            $table->foreign('institution_id')
                ->references('id')->on('institutions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('edited_by')
                ->references('id')->on('users')
                ->onDelete('SET NULL')
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
        Schema::dropIfExists('polls');
    }
}
