<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\SendAccessID;
use App\Model\UserResult;
use App\Model\DiagnosisResultType;

use App\Setting;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AdminMailController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getStyle($urec)
    {
        //診断結果データ
        $styles = DiagnosisResultType::where('diagnosis_table_id', $urec->title_id)->where('style', $urec->my_type)->get()->toArray();
        $result_contents = array();
        foreach ($styles as $s) {
            $result_contents[$s['style']] = $s;
        }

        return $result_contents;
    }

    private function getUserResult($user)
    {
        $urec = UserResult::first();
        $urec->name = "管理人";
        $urec->email = $user->email;
        $urec->access_id = "access-id-0123456789";
        $urec->my_type = "A";

        return $urec;
    }

    //テストメール処理
    public function mail_test($pos=1)
    {
        session()->forget('status');    //なぜか、セッションflashが続くから消去
        $user = Auth::user();

        $urec = $this->getUserResult($user);
        $result_contents = $this->getStyle($urec);
        $obj = new SendAccessID($urec, $result_contents);
        //アクセスID送信
        for ($i=0;$i<1;$i++) {
            $email[] = $this->make_email_data($i+1, $urec, $result_contents);
        }

        if ($pos<1 || $pos>count($email)) {
            $pos=1;
        }

        //送信元、送信先
        $from_to[] = $this->chg_mailaddress($obj->from);
        $from_to[] = $this->chg_mailaddress($obj->to);

        //件名プレフィックス　ーシステム名
        $app_name = config('all.app_name');

        return view('admin.mail_test')->with(["pos"=>$pos, "user"=>$user,"from_to"=>$from_to, "emails"=>$email, "app_name"=>$app_name]);
    }

    private function chg_mailaddress($obj)
    {
        return is_array($obj) ? sprintf("%s<%s>", $obj[0]['name'], $obj[0]['address']) : $obj;
    }

    private function getMailClass($id, $urec, $style)
    {
        switch ($id) {
            case 1:
                return (new SendAccessID($urec, $style));
                break;

            default:
                return null;
                break;
        }
    }

    private function make_email_data($id, $urec, $style)
    {
        $ret = [];

        $email = $this->getMailClass($id, $urec, $style);

        $email = $email->build();
        $ret[] = $email->subject;
        $ret[] = nl2br($email->render());

        return $ret;
    }

    public function getMailTitle($id)
    {
        $title = "アクセスID";
        switch ($id) {
            case 1:
                break;
            default:
                break;
        }

        return $title;
    }

    public function mail_send_test(Request $req)
    {
        $user = Auth::user();

        $id = $req->input('id');
        $title = $this->getMailTitle($id);
        try {
            $user->send_test_mail = true;
            switch ($id) {
                case 1:
                    //メール送信
                    $urec = $this->getUserResult($user);
                    $result_contents = $this->getStyle($urec);
                    Mail::to($urec->email)->send(new SendAccessID($urec, $result_contents));
                    if (Mail::failures()) {
                        dd(Mail);
                    }
                    break;
                default:
                    break;
            }
        } catch (Exception $e) {
            response()->json(['code'=>'NG', 'message'=>$e->message]);
        }

        return response()->json(['code'=>'OK', 'message'=>"($title)送信しました"]);
    }

    public function mail_edit(Request $req)
    {
        $user = Auth::user();

        $id = $req->input('id');
        $email = $this->makeMailEditInfo($id);
        $title = $this->getMailTitle($id);

        $urec = $this->getUserResult($user);
        $result_contents = $this->getStyle($urec);
        $obj = new SendAccessID($urec, $result_contents);
        //送信元、送信先
        $from_to[] = [$obj->from[0]['name'], $obj->from[0]['address'],];
        $from_to[] = $this->chg_mailaddress($obj->to);

        if ($req->input('action', '')=='save') {
            $email[1] = $req->input('subject');
            $email[2] = $req->input('body');
            $ret = $this->mail_edit_validate($req, $id, $user);
            if ($ret) {
                //保存処理
                session()->flash('alert_type', 'success');
                session()->flash('status', "保存致しました");
            } else {
                //保存処理
                session()->flash('alert_type', 'danger');
                session()->flash('status', "本文でエラーが発生しました、保存できませんでした");
            }
        }

        //dd($user, $from_to, $email, $id, $title);
        return view('admin.mail_edit')->with(["user"=>$user, "from_to"=>$from_to, "email"=>$email, "id"=>$id, "title"=>$title]);
    }

    private function getMailBlade($pos)
    {
        $blades = [
            "",
            "access_id_text",
        ];

        return $blades[$pos];
    }

    private function makeMailEditInfo($id)
    {
        //
        $blade = $this->getMailBlade($id);
        $filename = resource_path('views/mails/').$blade.".blade.php";
        $ret[] = "";
        $ret[] = '[コミュニケーションスタイル診断] <$urec->name>様の診断結果へのアクセス情報をお送りいたします。';
        $ret[] = \File::get($filename);

        return $ret;
    }

    private function mail_edit_validate($req, $id, $user)
    {
        //件名
        $subject = $req->input('subject');
        //本文
        $body = $req->input('body');

        //本文のチェック
        //validate用のbladeを作成
        $blade = $this->getMailBlade($id);
        $validate_path = resource_path('views/mails/');
        \File::makeDirectory($validate_path, 0777, false, true);
        $filename = $validate_path.$blade.".blade.php";

        \File::put($filename, $body);

        $urec = $this->getUserResult($user);
        $result_contents = $this->getStyle($urec);
        $email = $this->getMailClass($id, $urec, $result_contents);
        //$email->setValidate();

        $email = $email->build();
        try {
            $email->render();
        } catch (\Exception $e) {
            //レンダーエラーとする
            return false;
        }

        //エラーが発生しなかったので、切り替え バックアップを作成
        $backup_path = resource_path('views/mails/backup/');
        \File::makeDirectory($backup_path, 0777, false, true);
        $src_filename = resource_path('views/mails/').$blade.".blade.php";
        $dst_filename = $backup_path.$blade.".blade.php";
        \File::copy($src_filename, $dst_filename);
        /*Setting::updateOrCreate(
            ['config'=>$blade."_backup", 'key'=>'subject',],
            ['value'=>config('mail_'.$blade.".subject")]
        );*/

        //上書き
        \File::put($src_filename, $body);
        /*
        config(['mail_'.$blade.".subject" => $subject,]);
        Setting::where('config', '=', $blade)
            ->where('key', '=', 'subject')
            ->update(['value'=>$subject]);
            */

        return true;
    }
}
