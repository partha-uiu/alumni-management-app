<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alumni_title')->nullable();
            $table->string('department_slogan_title')->nullable();
            $table->text('department_slogan_elaboration')->nullable();
            $table->string('mission_vision_title')->nullable();
            $table->text('mission_vision_description')->nullable();
            $table->string('foundation_date')->nullable();
            $table->string('total_alumni')->nullable();
            $table->string('current_students')->nullable();
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
        Schema::dropIfExists('about_contents');
    }
}
