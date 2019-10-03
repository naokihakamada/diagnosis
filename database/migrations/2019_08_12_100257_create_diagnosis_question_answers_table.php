<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_question_answers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('diagnosis_question_id')->index();
            $table->integer('no');
            $table->string('answer');
            $table->integer('blockA_value');
            $table->integer('blockB_value');
            $table->integer('blockC_value');
            $table->integer('blockD_value');

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
        Schema::dropIfExists('diagnosis_question_answers');
    }
}
