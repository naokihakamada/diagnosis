<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\DiagnosisQuestionAnswer;

class DiagnosisQuestion extends Model
{
    //
    public function answers()
    {
        //$ret = $this->hasMany("App\Model\DiagnosisQuestionAnswer", "diagnosis_question_id");

        $ret =  DiagnosisQuestionAnswer::where("diagnosis_question_id", $this->id)->orderBy("id")->get();
        return $ret;
    }
}
