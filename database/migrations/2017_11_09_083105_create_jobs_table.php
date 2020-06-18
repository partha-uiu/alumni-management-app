<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('job_title');
            $table->string('company_name');
            $table->string('position')->nullable();
            $table->string('job_type');
            $table->string('vacancy')->nullable();
            $table->string('location');
            $table->text('description');
            $table->date('post_date');
            $table->date('end_date');
            $table->string('url')->nullable();
            $table->string('image_url')->nullable();
            $table->tinyInteger('is_approved')->default(0);
            $table->integer('approved_by')->unsigned()->nullable();
            $table->integer('edited_by')->unsigned()->nullable();
            $table->string('edit_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('approved_by')
                ->references('id')->on('users')
                ->onDelete('SET NULL')
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
        Schema::dropIfExists('jobs');
    }
}
