<?php

namespace App\Http\Controllers;

use App\Model\DiagnosisQuestion;
use App\Model\DiagnosisResultType;
use App\Model\DiagnosisTitle;
use App\Model\User;
use App\Model\UserResult;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view("admin.index");
    }

    public function titles()
    {
        $titles = DiagnosisTitle::all();

        return view("admin.titles", ['titles'=>$titles]);
    }

    public function questions($title_id)
    {
        $questions = DiagnosisQuestion::where("diagnosis_table_id", $title_id)->orderBy('no')->get();

        return view("admin.questions", ['questions'=>$questions,]);
    }

    public function types($title_id)
    {
        $types = DiagnosisResultType::where("diagnosis_table_id", $title_id)->orderBy("style")->get();

        return view("admin.types", ['types'=>$types,]);
    }

    public function logs()
    {
        $logs = UserResult::all();

        return view("admin.logs", ['logs'=>$logs,]);
    }

    public function log_action(Request $req)
    {
        $id = $req->input("user_id");
        switch ($req->input('form-type')) {
            case '1'://再診断
                //回答、タイプをクリアする
                $urec = UserResult::where("id", $id)->first();
                if (is_null($urec)) {
                    abort(404);
                }
                $urec->answer = "";
                $urec->my_type = "";
                $urec->save();
                break;
            case '2'://新規へ
                break;
            default:
                break;
        }
        return $this->logs();
    }
}
