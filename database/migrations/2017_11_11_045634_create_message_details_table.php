<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->integer('sender_msg_status')->unsigned();
            $table->integer('receiver_msg_status')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('message_id')
                ->references('id')->on('messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sender_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('receiver_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('parent_id')
                ->references('id')->on('message_details');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_details');
    }
}
