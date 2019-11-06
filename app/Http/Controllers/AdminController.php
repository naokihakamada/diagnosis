<?php

namespace App\Http\Controllers;

use App\Model\DiagnosisQuestion;
use App\Model\DiagnosisResultType;
use App\Model\DiagnosisTitle;
use App\Model\User;
use App\Model\UserResult;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $logs = UserResult::orderBy('id', 'desc')->paginate(20);

        //回答にかかった時間を追加する
        foreach ($logs as $log) {
            if (is_null($log->p1) || is_null($log->p2)) {
                $log->pp2 = "";
            } else {
                $p1 = new Carbon($log->p1);
                $p2 = new Carbon($log->p2);
    
                $log->pp2 = $p2->diffInSeconds($p1);
            }
        }
        
        return view("admin.logs", ['logs'=>$logs,]);
    }

    public function log_action(Request $req)
    {
        $id = $req->input("user_id");
        switch ($req->input('form-type')) {
            case '1'://リセット
                //アクセスIDのまま、再診断ができる
                $urec = UserResult::where("id", $id)->first();
                if (is_null($urec)) {
                    abort(404);
                }
                $urec->answer = "";
                $urec->my_type = "";
                $urec->p1 = null;
                $urec->p2 = null;
                $urec->p3 = null;
                $urec->save();
                break;
            case '2'://削除
                //なかったことになる
                UserResult::where('id', $id)->delete();
                break;
            default:
                break;
        }
        return $this->logs();
    }
}
