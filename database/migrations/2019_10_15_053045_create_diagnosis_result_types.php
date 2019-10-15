<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisResultTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_result_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('diagnosis_table_id')->index();
            $table->string('style');
            $table->string('type');
            $table->string('name');
            $table->string('kana');

            $table->text('contents');
            $table->text('communication');

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
        Schema::dropIfExists('diagnosis_result_types');
    }
}
