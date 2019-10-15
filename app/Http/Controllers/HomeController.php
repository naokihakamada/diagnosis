<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DiagnosisTitle;
use App\Model\DiagnosisQuestion;
use App\Model\UserResult;
use Carbon\Carbon;

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
        //入力の再現（クッキーより)
        if ($diag == "1") {
            $set_req = array('title_id' => $id);
            $ans = $req->cookie('answers');
            for ($i=0;$i<strlen($ans);$i++) {
                $key = 'q-'.strval($i+1);
                $set_req += array($key => substr($ans, $i, 1));
            }
            $req->merge($set_req);
            return $this->diagnosis_result($req);
        } else {
            //まだ診断していない
            //空認証レコード？
            //session_id
            $s_id = $req->session()->getId();
            UserResult::firstOrCreate(['session_id' => $s_id, 'title_id'=> $id, 'alias'=>$alias, 'p1'=>Carbon::now()]);
        }

        $questions = $this->getQuestions(null, $id);

        return view('questions', ["title_id"=>$id, "alias"=>$alias, "questions"=>$questions, "question_count"=>count($questions),]);
    }

    public function diagnosis_check(Request $req)
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
            abort(404);
        }
        //回答、チェック時間、
        $urec->answer = $req->cookie('answers');
        $urec->p2 = Carbon::now();
        $urec->save();

        return view('questions_check', ["title_id"=>$id, "alias"=>$alias, "req"=>$req, "checks"=>$checks, "questions"=>$questions, "question_count"=>count($questions),]);
    }

    private $result_contents = [
    "A" => ["type"=>"理論・分析型", "name"=>"Analytical", "kana"=>"アナリティカル",
        "contents"=>"
        <h4>感情：抑える<br />意見：受け止める</h4>
        <h5>[特徴]:思考派(論理的/計画的)</h5>
        <p>原則・事実へのこだわりが強く、リスクを避
        けたがるため、意見をあまり表に出さない傾
        向があります。
        これにより「真面目で堅苦しい」という印象
        を与えてしまうことが多くあります。
        他人との間に親近感を生むよう、自分の考え
        や感情を表に出すことが求められます。</p>
        <h5>[キーワード]</h4>
        <p>冷静、自立心、時間に厳格、しっかり準備、
        事実・データを好む、リスクを避ける など</p>",
        "comm"=>"
        <p>このタイプには、礼儀正しく、ゆっくり丁寧に話をする。<br />
        科学的根拠や事実といった、データを提示しながら、筋道を立てて話をすると安心感を持ってもらい易い。</p>
        <h4>詳細</h4>
        <p>論理や根拠を重視し、自分が納得しないと動かないという意志の固いタイプです。<br />
        あまり感情が表に出ないため、興味を持たれているかどうかわかりづらいですが、自分にとって有益・興味を持てると感じたら、とことん取り組む。という特徴を持っています。<br />
        そのため、まずは相手が何を気にしているのかを網羅的に確認し、それに応じた情報を提供し続けてあげるとよいでしょう。<br />
        メリットだけでなくデメリットも共有したり、数値化したデータを提供するなど、比較検討しやすいように情報を提供することもポイントです。<br />
        急かされることは好みませんので、何か意思決定を促す際も、ある程度余裕を持った期日設定が必要です。<br />
        </p>
        <h4>注意するポイント</h4>
        <p>・準備をちゃんとする<br />
        ・選択肢を用意する<br /> 
        ・質問の意図を明確にする<br /> 
        ・考える余地を与える<br /> 
        ・感情的な対応はNG!<br /> 
        ・せかさない<br /> 
        ・メリット/デメリットの提示<br /> 
        ・こちらが先に結論を出さないこと<br /> 
        ・考え方を褒める<br />
        ・網羅性がないと×<br />
        ・考えが浅いと×</p>
        <h4>クロージングのポイント</h4>
        <p>判断(結論を出す)に時間がかかるが、決して急かさない!</p>
        <h4>相性</h4>
        <p>○:行動・遂行型 / 目上の直感・直情型<br /> 
        △:目下の友好・融和型<br />
        ✖ :目上の友好・融和型 / 目下の直感・直情型</p>
        "],
    "B" => ["type"=>"行動・遂行型", "name"=>"Driving", "kana"=>"ドライビング",
        "contents"=>"
        <h4>感情：抑える<br />意見：主張する</h4>
        <h5>[特徴]:行動派(現実的/成果主義)</h5>
        <p>行動が早い上に競争意欲が旺盛なため、自分
        主体で物事を進めようとする傾向があります。
        そのため、相手への理解を示す言動や、配慮
        が足りない場合が多く反発を受けやすい。
        相手の話に耳を傾けて、感情のこもった対応
        を心がけることが望まれます。</p>
        <h5>[キーワード]</h4>
        <p>行動的、とっつきにくい、負けず嫌い、ス
        ピーディー、時間に厳格、マイペース など
        </p>",        "comm"=>"
        <p>このタイプには、挨拶、雑談は手短にして早く本題に入る。<br />
        はきはきとした口調で、何より結論を先に伝える。<br />
        ポイントをついた話をしながらも、その場の主導権を相手にとらせることが重要。</p>
        <h4>詳細</h4>
        <p>合理的な考えの持ち主。結果を重視し、無駄なことを嫌います。<br />
        そのため、会話は論理的に進めることが重要。結論から先に伝え、そのあと理由、具体例といったように順序立てて話していく。というように、相手の知りたいことに対して端的に答えていくとプラスです。<br />
        あまり感情(表情)は表に出さず、早口で淡々と自分の意見を言う傾向があり、せっかちで負けず嫌い。<br />
        自分のキャリアに自信を持っており、目的のためには、厳しい判断も辞さないところがあります。<br />
        また、キャリア形成や市場価値の向上に興味があるため、ポジションの重要性や仕事の難易度を伝えることが動機づけ、モチベーションを高める要素となります。
        </p>
        <h4>注意するポイント</h4>
        <p>・前置きは短く<br />
        ・無駄を省く<br />
        ・単刀直入にポイントをつく<br />
        ・背景を確認<br />
        ・結果を褒める<br />
        ・能力を見せる<br />
        ・締め切りを守る<br />
        ・結果を(コミット)断言する<br />
        ・指示に従う(やり遂げる)<br />
        ・いじると喜ぶ<br />
        ・ネガティブな反応は×<br />
        ・前置きが長いと×<br />
        ・他との比較(お得・優れている等)<br />
        ・多少リスクがあっても構わない</p>
        <h4>クロージングのポイント</h4>
        <p>こちら都合の頻繁な連絡は避ける。</p>
        <h4>相性</h4>
        <p>○:理論・分析型 / 目上の友好・融和型<br />△:行動・遂行型 / 目下の直感・直情型<br />
        ✖ :目下の友好・融和型 / 目上の直感・直情型</p>
        "],

    "C" => ["type"=>"友好・融和型", "name"=>"Amiable", "kana"=>"エミアブル",
        "contents"=>"
        <h4>感情：表す<br />意見：受け止める</h4>
        <h5>[特徴]:協調派(友好的/安定的)</h5>
        <p>協調的なために関係を上手く保とうと周囲に 対して一歩引いた立場を好み、強く意見を言 う事や、自ら率先して人を引っ張るというこ とを避ける傾向があります。
        仕事という成果が求められる場面においては
        自分から率先して行動を起こすことが求めら
        れます。</p>
        <h5>[キーワード]</h4>
        <p>親しみやすい、聞き上手、協力的、時間に
        ルーズ、感情が分かり易い など
        </p>",
        "comm"=>"
        <p>このタイプには、世間話や個人的な話を入れて、相手との共通点を見つけて安心感を与える。<br />
        丁寧に粘り強く対応することで、熱意や誠意を感じてもらい易い。</p>
        <h4>詳細</h4>
        <p>不安を感じやすいタイプなので、安心感を醸成することがポイントです。<br />
        まずはこちらから、積極的に自己開示をして、相手の性格や考え方を褒める、評価している部分を具体的に伝えるとプラスです。ç<br />
        八方美人になりがちで他人の顔色を見て優 柔不断なる、決断に時間がかかってしまう 傾向があり、決断を無理にせまれば心が離 れたり、多大なストレスを感じます。<br />
        「あなたの納得のいく選択をしてください。」というように、少し引いた位置から安心感を与えるコミュニケーションを心がける、「一緒に考えませんか」といったように、相手に共感を持って接すると良いでしょう。<br />
        職場においては、いい人間関係の中で楽しく、安心して働ける環境を求める傾向があります。
        </p>
        <h4>注意するポイント</h4>
        <p>・こちらから自己開示する<br /> 
        ・親身、真摯な態度で接する<br /> 
        ・結論を急がず一緒に考える<br /> 
        ・性格を褒める<br /> 
        ・プロセスを褒める<br /> 
        ・身の上話をして同情を引く<br /> 
        ・仲良しグループに入れる<br /> 
        ・レッツの精神<br /> 
        ・結論への導入が短いと不安になる<br /> 
        ・真剣な態度が何より重要<br /> 
        ・いかに権威があるかを強調する<br />
        「最高クラスのAAA評価」<br />
        「あなただけのサービス」</p>
        <h4>クロージングのポイント</h4>
        <p>あまり押しすぎず、あくまで本人の意思にゆだねる</p>
        <h4>相性</h4>
        <p>○:直感・直情型 / 目下の行動・遂行型<br /> 
        △:目上の理論・分析型<br />
        ✖ :目上の行動・遂行型 / 目下の理論・分析型</p>
        "],

    "D" => ["type"=>"直感・直情型", "name"=>"Expressive", "kana"=>"エスクプレッシブ",
        "contents"=>"
        <h4>感情：表す<br />意見：主張する</h4>
        <h5>[特徴]:感覚派(社交的/直感的)</h5>
        <p>何事に対しても興味を持ちやすく、衝動的か
        つ、直情的な行動傾向が強いです。
        自分を客観的に見たり抑えたりすることが苦
        手ですが、良い意味で周囲を引っ張るムード
        メーカーになる場合が多いです。
        常に落ち着いた発言、行動が望まれます。</p>
        <h5>[キーワード]</h4>
        <p>直感、好奇心、自分語り、時間にルーズ、 マイペース、気分屋 など
        </p> ",
        "comm"=>"
        <p>このタイプには、明るく、元気な対応をこころがける。<br />
        本題とは関係の無いことでも、興味のありそうな情報を提示したり相手の意見に共感を示す。<br />
        また、話が盛り上がる様に、世間の話題をだしたり、話し方や スピード(リズム)を相手に合わせる。</p>
        <h4>詳細</h4>
        <p>自ら積極的に話しをするので、相手に同調しながら、多少大げさに反応するなど、喜怒哀楽を共にすると心を掴みやすくなります。楽しい雰囲気(ノリを重視。注目されたい。新しい、話題性のあることが好き) を好むので、商談や面談時には最初から本題に入るのではなく、世間話をいれるとプラスです。<br />
        感情で動くため、発言内容が直観的に変わる傾向があり、柔軟な対応が望まれます。また、仕事の方針を前触れなく変えてしまうときもあります。重要な方針などは、変わる前に「言質を取り文書化する」という工夫も必要です。
        企業のビジョンや社会的意義を魅力に感じやすいタイプなので、「このビジョンを達成するために、ぜひあなたに協力してほしい」など情熱を伝えることでモチベーションも高まりやすくなります。
        </p>
        <h4>注意するポイント</h4>
        <p>・世間話から入る<br />
        ・楽しい雰囲気をつくる<br /> 
        ・説明は短く<br />
        ・本人に花を持たせる<br /> 
        ・その人自身を褒める<br /> 
        ・自尊心をくすぐる<br />
        ・気合を見せる<br />
        ・前置きが長いと× <br />
        ・結論を短く(論理的でなくても可)<br />
        ・華やかな企画なら多少のリスクも○<br />
        ・ねばりは有効<br />
        ・セールスの場合<br />
         「土日には御家族そろって試乗会」<br />
         「夢と魔法の王国へご招待」</p>
        <h4>クロージングのポイント</h4>
        <p>頻繁に連絡を取り、熱意を伝える。</p>
        <h4>相性</h4>
        <p>○:友好・融和型 / 目下の理論・分析型<br /> 
        △:目上の行動・遂行型 / 直感・直情型<br />
        ✖ :目下の行動・遂行型 / 目上の理論・分析型</p>
        "],

];

    public function diagnosis_result(Request $req)
    {
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

        //
        $s_id = $req->session()->getId();
        $urec = UserResult::where('session_id', $s_id)->first();
        if (is_null($urec)) {
            abort(404);
        }
        //回答、チェック時間、
        $urec->p3 = Carbon::now();
        $urec->save();

        //$titles = DiagnosisTitle::all();
        return view('result', ["title_id"=>$id, "results"=>$results,"my_type"=>$my_type, "result_contents"=>$this->result_contents]);
    }

    public function save(Request $req)
    {
        //title_id,name,email
        $s_id = $req->session()->getId();
        $urec = UserResult::where('session_id', $s_id)->first();
        if (is_null($urec)) {
            abort(404);
        }
        //保存
        $urec->name = $req->input('name');
        $urec->email = $req->input('email');
        $urec->p4 = Carbon::now();
        //access_id
        $access_id = uniqid()."0".$urec->id;
        $urec->access_id = $access_id;
        //
        $urec->save();
    }

    private function getQuestions($req, $id=null)
    {
        if (is_null($id)) {
            $id = $req->input('title_id');
        }
        if (is_null($id)) {
            abort(404);
        }

        $questions = DiagnosisQuestion::where("diagnosis_table_id", $id)->orderBy("id")->limit(5)->get();
        if (is_null($questions)) {
            abort(404);
        }

        return $questions;
    }

    public function diagnosis_comm($type)
    {
        return view('comm', ["my_type"=>$type, "result"=>$this->result_contents[$type]]);
    }
}
