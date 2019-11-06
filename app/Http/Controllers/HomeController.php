<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\DiagnosisTitle;
use App\Model\DiagnosisQuestion;
use App\Model\DiagnosisResultType;
use App\Model\UserResult;
use Carbon\Carbon;
use App\Mail\SendAccessID;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $titles = DiagnosisTitle::all();
        return view('title', ["titles"=>$titles,]);
    }

    public function diagnosis($alias, Request $req)
    {
        $titles = DiagnosisTitle::where("alias", '=', $alias)->first();
        $id = null;
        if ($titles) {
            $id = $titles->id;
        }
        if (is_null($id)) {
            abort(404);
        }
        $diag = $req->cookie('diagnosis');
        //dd($diag, $req);
        //入力の再現（クッキーより)
        switch ($diag) {
           case "9":
                //アクセスidへリダイレクト
                $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
                if (is_null($urec)) {
                    Cookie::queue('diagnosis', "", 300*24*60, "/");
                    Cookie::queue('answers', "", 300*24*60, "/");
                    $s_id = $req->session()->getId();
                    $urec = UserResult::firstOrCreate(['session_id' => $s_id]);
                    $urec->title_id = $id;
                    $urec->alias =$alias;
                    $urec->p1 = Carbon::now();
                    $urec->save();
                    Cookie::queue('user_result_id', $urec->id, 300*24*60, "/");
                    break;
                }

                if ($urec->access_id) {
                    return redirect()->route('user_result', ['access_id'=>$urec->access_id, 'alias'=>$alias, ]);
                    break;
                }
                //何らかのセッションデータが食い違った
                Cookie::queue('diagnosis', "1", 300*24*60, "/");
                // no break
            case "1":
                $set_req = array('title_id' => $id, 'alias'=>$alias);
                $ans = $req->cookie('answers');
                for ($i=0;$i<strlen($ans);$i++) {
                    $key = 'q-'.strval($i+1);
                    $set_req += array($key => substr($ans, $i, 1));
                }
                $req->merge($set_req);
                return $this->diagnosis_result($req);
                break;
             case "-1":
                //再診断
                //user_resultの存在確認
                $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
                if (!is_null($urec)) {
                    //リセット
                    $urec->p1 = Carbon::now();
                    $urec->save();
                    break;
                }
                Cookie::queue('diagnosis', "", 300*24*60, "/");
                //user_resultがない場合には初期動作
                // no break
            default:
                //まだ診断していない
                //空認証レコード？
                //session_id
                $s_id = $req->session()->getId();
                $urec = UserResult::firstOrCreate(['session_id' => $s_id]);
                $urec->title_id = $id;
                $urec->alias =$alias;
                $urec->p1 = Carbon::now();
                $urec->save();
                Cookie::queue('user_result_id', $urec->id, 300*24*60, "/");
                break;
        }

        $questions = $this->getQuestions(null, $id);

        return view('questions', [
            "title_id"=>$id,
            "alias"=>$alias,
            "questions"=>$questions,
            "question_count"=>count($questions),
        ]);
    }

    public function diagnosis_check(Request $req, $bUserResult=false)
    {
        $id = $req->input('title_id');
        $alias = $req->input('alias');
        $questions = $this->getQuestions($req, $id);
        //整頓
        $checks = array("");
        foreach ($questions as $i=>$q) {
            array_push($checks, $req->input("q-".strval($i+1)));
        }
        //
        $s_id = $req->session()->getId();
        $urec = UserResult::where('session_id', $s_id)->first();
        if (is_null($urec)) {
            if (!is_null($req->cookie('user_result_id'))) {
                $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
            }
            if (is_null($urec)) {
                abort(404);
            }
        }

        //回答、チェック時間、
        $urec->answer = $req->cookie('answers');
        //直接回答結果を見る場合にのみ更新
        if (!$bUserResult) {
            $urec->p2 = Carbon::now();
        }
        $urec->save();

        return view('questions_check', [
            "title_id"=>$id,
            "alias"=>$alias,
            "req"=>$req,
            "checks"=>$checks,
            "questions"=>$questions,
            "question_count"=>count($questions),
        ]);
    }

    public function diagnosis_result(Request $req, $bUserResult=false, $answer_check=false, $user_record=null)
    {
        $this->diagnosis_check($req, $bUserResult);
        //結果判定
        $id = $req->input('title_id');
        $alias = $req->input('alias');
        $questions = $this->getQuestions($req, $id);

        $results = array("A"=>0,"B"=>0,"C"=>0,"D"=>0,);
        foreach ($questions as $no=>$question) {
            $inp = intval($req->input('q-'.strval($no+1)));

            foreach ($question->answers() as $ans) {
                if ($ans->no == $inp) {
                    //各診断点数を加算
                    $results["A"] += $ans->blockA_value;
                    $results["B"] += $ans->blockB_value;
                    $results["C"] += $ans->blockC_value;
                    $results["D"] += $ans->blockD_value;
                    break;
                }
            }
        }

        //ソート：点数＋パート
        arsort($results);

        //結果発表
        $my_type = key($results);

        //はじめての診断結果
        if (is_null($user_record)) {
            $s_id = $req->session()->getId();
            $urec = UserResult::where('session_id', $s_id)->first();
            if (is_null($urec)) {
                if (!is_null($req->cookie('user_result_id'))) {
                    $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
                }
                if (is_null($urec)) {
                    abort(404);
                }
            }
            //回答、チェック時間、
            $urec->my_type = $my_type;
            $urec->p3 = Carbon::now();
        } else {
            $urec = $user_record;
        }
        $urec->p4 = Carbon::now();
        if (!$bUserResult) {
            $urec->memo1 = $urec->memo1 . strval(Carbon::now()) . "|";
        }
        $urec->save();

        //既にアクセスIDをもっている
        if (!is_null($urec->access_id)) {
            $bUserResult = true;
        }
        Cookie::queue('diagnosis', "9", 300*24*60, "/");

        //診断結果データ
        $styles = DiagnosisResultType::where('diagnosis_table_id', $id)->get()->toArray();
        $result_contents = array();
        foreach ($styles as $s) {
            $result_contents[$s['style']] = $s;
        }

        //$titles = DiagnosisTitle::all();
        return view('result', [
            "title_id"=>$id,
            "alias"=>$alias,
            "questions"=>$questions,
            "results"=>$results,
            "my_type"=>$my_type,
            "result_contents"=>$result_contents,
            "user_record"=>$urec,
            "user_result"=>$bUserResult,
            "answer_check"=> $answer_check,
        ]);
    }

    public function save(Request $req)
    {
        //title_id,name,email
        $s_id = $req->session()->getId();
        $urec = UserResult::where('session_id', $s_id)->first();
        if (is_null($urec)) {
            //セッションが切れてしまった
            $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
            if (is_null($urec)) {
                abort(404);
            }
        }
        //保存
        $urec->name = $req->input('name');
        $urec->email = $req->input('email');
        $urec->p4 = Carbon::now();
        //access_id
        $access_id = uniqid()."0".$urec->id;
        $urec->access_id = $access_id;
        $alias = $urec->alias;
        //
        $urec->save();

        //診断結果データ
        $styles = DiagnosisResultType::where('diagnosis_table_id', $urec->title_id)->where('style', $urec->my_type)->get()->toArray();
        $result_contents = array();
        foreach ($styles as $s) {
            $result_contents[$s['style']] = $s;
        }

        //メール送信
        Mail::to($urec->email)->send(new SendAccessID($urec, $result_contents));
        if (Mail::failures()) {
            dd(Mail);
        }

        //アクセスidへリダイレクト
        return redirect()->route('user_result', ['access_id'=>$access_id, 'alias'=>$alias, ]);
    }

    public function user_result($alias, $access_id, Request $req, $answer_check=false)
    {
        //access_id での読み込み
        $urec = UserResult::where('access_id', $access_id)->first();
        if (is_null($urec)) {
            abort(404);
        }
        if ($urec->alias <> $alias) {
            abort(404);
        }
        //再回答へ戻るには　回答(answer)をクリアする
        if ($urec->answer == "") {
            //クリア要請により再回答へ cookie を削除
            Cookie::queue('diagnosis', "-1", 300*24*60, "/");
            Cookie::queue('answers', "", 300*24*60, "/");
            return redirect()->route('diagnosis', ['alias'=>$alias, ]);
        }

        $set_req = array('title_id' => $urec->title_id, "alias"=>$alias);
        $ans = $urec->answer;
        for ($i=0;$i<strlen($ans);$i++) {
            $key = 'q-'.strval($i+1);
            $set_req += array($key => substr($ans, $i, 1));
        }
        $req->merge($set_req);

        //アクセス回数を保存する
        if (!$answer_check) {
            //結果を見に来た
            $urec->memo1 = $urec->memo1 . strval(Carbon::now()) . "|";
            $urec->save();
        }

        return $this->diagnosis_result($req, true, $answer_check, $urec);
    }

    public function user_answer($alias, $access_id, Request $req)
    {
        return $this->user_result($alias, $access_id, $req, true);
    }

    private function getQuestions($req, $id=null)
    {
        if (is_null($id)) {
            $id = $req->input('title_id');
        }
        if (is_null($id)) {
            abort(404);
        }

        $limit=intval(env("QUESTION_COUNT", "-1"));
        if ($limit>0) {
            $questions = DiagnosisQuestion::where("diagnosis_table_id", $id)->orderBy("id")->limit($limit)->get();
        } else {
            $questions = DiagnosisQuestion::where("diagnosis_table_id", $id)->orderBy("id")->get();
        }
        if (is_null($questions)) {
            abort(404);
        }

        //ランダムに取り出す

        return $questions;
    }

    public function diagnosis_comm($alias, $type, Request $req)
    {
        //title_id,name,email
        $s_id = $req->session()->getId();
        $urec = UserResult::where('session_id', $s_id)->first();
        if (is_null($urec)) {
            //セッションが切れてしまった
            $urec = UserResult::where('id', $req->cookie('user_result_id'))->first();
            if (is_null($urec)) {
                abort(404);
            }
        }

        $titles = DiagnosisTitle::where("alias", '=', $alias)->first();
        //診断結果データ
        $styles = DiagnosisResultType::where('diagnosis_table_id', $titles->id)->get()->toArray();
        $result_contents = array();
        foreach ($styles as $s) {
            $result_contents[$s['style']] = $s;
        }

        return view('comm', [
            "comm_type"=>$type,
            "my_type"=>$urec['my_type'],
            "alias"=>$alias,
            "user_record"=>$urec,
            "result_contents"=>$result_contents,
        ]);
    }

    public function data_clear(Request $req)
    {
        return view("data_clear");
    }
    public function data_cleared(Request $req)
    {
        if ($req->input('pass') == "ecm-training_") {
            $req->session()->regenerate();
            setcookie('answers', "", time()-60);
            setcookie('diagnosis', "", time()-60);
            setcookie('user_result_id', "", time()-60);
        
            return view("data_cleaned");
            return redirect()->route('index');
        }

        abort(404);
    }
}
