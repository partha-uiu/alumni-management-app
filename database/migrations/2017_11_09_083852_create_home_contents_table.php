<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alumni_association_title')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('home_image_url')->nullable();
            $table->string('nav_color')->nullable();
            $table->string('box_title_1')->nullable();
            $table->text('box_description_1')->nullable();
            $table->string('box_title_2')->nullable();
            $table->text('box_description_2')->nullable();
            $table->string('box_title_3')->nullable();
            $table->text('box_description_3')->nullable();
            $table->string('box_title_4')->nullable();
            $table->text('box_description_4')->nullable();
            $table->string('content_box_5_title')->nullable();
            $table->text('content_box_5_description')->nullable();
            $table->string('contact_heading')->nullable();
            $table->text('contact_description')->nullable();
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
        Schema::dropIfExists('home_contents');
    }
}
