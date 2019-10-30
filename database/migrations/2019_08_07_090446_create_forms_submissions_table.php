<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('form_id');
            $table->BigInteger('user_id')->unsigned()->index();
            $table->text('content');
			$table->string('status')->nullable();
			$table->string('comments')->nullable();
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }
}
