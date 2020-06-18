<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorshipTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentorship_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('edited_by')->unsigned()->nullable();
            $table->string('edit_time')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('mentorship_topics');
    }
}
