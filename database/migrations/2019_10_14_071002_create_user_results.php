<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_results', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('access_id')->nullable();
            $table->string('session_id');

            $table->integer('title_id');
            $table->string('alias');
            $table->string('answer')->nullable();

            $table->timestamp('p1')->nullable();
            $table->timestamp('p2')->nullable();
            $table->timestamp('p3')->nullable();
            $table->timestamp('p4')->nullable();

            $table->text('memo1')->nullable();
            $table->text('memo2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_results');
    }
}
