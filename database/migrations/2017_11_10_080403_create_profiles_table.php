<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('address')->nullable();
            $table->string('dist_state');
            $table->integer('country_id')->unsigned();
            $table->string('registration_number')->nullable();
            $table->string('profile_photo_url')->nullable();
            $table->integer('session_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned();
            $table->integer('institution_id')->unsigned();
            $table->string('company_institute')->nullable();
            $table->string('position')->nullable();
            $table->string('dob')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('contact_no')->nullable();
            $table->text('summary')->nullable();
            $table->tinyInteger('visibility_status')->default(1);
            $table->integer('edited_by')->unsigned()->nullable();
            $table->string('edit_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('profiles');
    }
}
