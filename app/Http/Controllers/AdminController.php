<?php

namespace App\Http\Controllers;

use App\Model\DiagnosisQuestion;
use App\Model\DiagnosisResultType;
use App\Model\DiagnosisTitle;
use App\Model\User;
use App\Model\UserResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Export\UsersExport;

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

        return view("admin.questions", ['title_id'=>$title_id, 'questions'=>$questions,]);
    }

    public function types($title_id)
    {
        $types = DiagnosisResultType::where("diagnosis_table_id", $title_id)->orderBy("style")->get();

        return view("admin.types", ['title_id'=>$title_id, 'types'=>$types,]);
    }

    public function type_edit($title_id, $style, Request $req)
    {
        $types = DiagnosisResultType::where("diagnosis_table_id", $title_id)->where('style', $style)->orderBy("style")->get();

        return view("admin.type_edit", ['title_id'=>$title_id, 'types'=>$types,]);
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
            //閲覧回数
            $log->view_count = count(explode("|", $log->memo1));
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

    public function logs_emails(Request $req)
    {
        //ログの中より 名前、email のリストをダウンロード
        return (new UsersExport)->downloadNow();

        $users = UserResult::whereNotNull("email")->get();
        dd($users);
    }

    public function question_edit($title_id, $no, Request $req)
    {
        $questions = DiagnosisQuestion::where("diagnosis_table_id", $title_id)->where("no", $no)->get();
        return view("admin.question_edit", ['title_id'=>$title_id, 'no'=>$no, 'questions'=>$questions,]);
    }

    public function question_edit_update($title_id, $no, Request $req)
    {
        //dd($req);
        //
        $question = DiagnosisQuestion::where("diagnosis_table_id", $title_id)->where("no", $no)->first();
        $question->title = $req->input("question_title");
        $question->save();

        //選択肢
        $answs = $question->answers();
        foreach ($answs as $ans) {
            $key = "ano-".strval($ans->no);
            $ano = intval($req->input($key));
            //
            //dd($ans, $key, $ano, $no, $ans->no, $req);
            if ($ano == $ans->no) {
                $ans->answer = $req->input($key . "-answer");
                $ans->blockA_value = $req->input($key . "-A");
                $ans->blockB_value = $req->input($key . "-B");
                $ans->blockC_value = $req->input($key . "-C");
                $ans->blockD_value = $req->input($key . "-D");
                //
                $ans->save();
            }
        }

        \Session::flash('status', '更新しました');

        return $this->question_edit($title_id, $no, $req);
    }

    public function type_edit_update($title_id, $style, Request $req)
    {
        $types = DiagnosisResultType::where("diagnosis_table_id", $title_id)->where('style', $style)->orderBy("style")->get();

        foreach ($types as $ty) {
            if ($ty->style == $req->input("style")) {
                $ty->type = $req->input("style-type");
                $ty->name = $req->input("style-name");
                $ty->kana = $req->input("style-kana");
                $ty->type = $req->input("style-type");
                $ty->color = $req->input("style-color");

                $ty->contents = $req->input("style-contents");
                $ty->communication = $req->input("style-communication");

                $ty->save();
            }
        }

        return $this->type_edit($title_id, $style, $req);
    }
}
