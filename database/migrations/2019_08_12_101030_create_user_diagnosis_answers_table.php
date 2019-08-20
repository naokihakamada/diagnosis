<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDiagnosisAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_diagnosis_answers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_diagnosis_id')->index();

            $table->integer('diagnosis_question_id');
            $table->integer('diagnosis_question_answer_id');

            $table->integer('answer_no');
            $table->string('block');
            $table->integer('value');

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
        Schema::dropIfExists('user_diagnosis_answers');
    }
}
