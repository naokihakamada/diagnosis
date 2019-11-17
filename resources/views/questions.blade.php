@extends('layouts.app')

@section('content')
<script>
    function check_input(){
        //すべて回答しているかのチェック
        for(i=1;i<={{$question_count}};i++){
            r = $('input[name=q-'+i+']:checked').val();
            if (r === undefined) {
                alert('未入力がございます');
                $('input[name=q-'+i+']').focus();
                return;
            }
        }

        $.cookie('diagnosis', '1', {expires: 300, path:"/"});
        document.answer_form.submit();
    }

    var answers="";
    $(document).ready( function(){

        if(!$.cookie('answers')){
            $.cookie('diagnosis', '', {expires: 300, path:"/"});
            @php echo "$.cookie('answers', '".str_repeat('0', $question_count)."', { expires: 300, path:'/' });" @endphp
        }
        answers = $.cookie('answers');
@if(0)
        // ページ読み込み時に実行したい処理
        var cookie = Cookies.get();
        if(!cookie['answers']){
            //最初のアクセス
            Cookies.set('diagnosis', "", { expires: 365, path: '/' });
            @php echo "Cookies.set('answers', '".str_repeat('0', $question_count)."', { expires: 365, path: '/' });" @endphp
        }
        answers = Cookies.get('answers');
        console.log(answers);
        console.log(Cookies.get('diagnosis'));
@endif

        //回答の再現
        for(i=0;i<answers.length;i++){
            var v = answers.substr(i,1);
            if(v != "0"){
                $("input[name=q-"+(i+1)+"]").val([v]);
                $("#label-"+(i+1)+"-"+v).toggleClass('active');
            }
        }

    });

    function onClickAnswer(no,ans,q_count){
        var l = answers.substr(0,no-1);
        var r = answers.substr(no);
        answers = l + ans + r;
        //console.log(answers);
        //Cookies.set('answers', answers, { expires: 365 });
        $.cookie('answers', answers, {expires: 300, path:"/"});

        //次の質問へスクロール
        if(no < q_count){
            $("html,body").animate({scrollTop:$('#block-'+(no+1)).offset().top});
        }
    }
 </script>

<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center" style="margin-bottom:1em;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body q-card-title alert-info  bg-white" >
                設問を読んで「直感」で判断し、回答を選択してください。<br /><br />
                <mark>設問は全部で{{$question_count}}問ございます。</mark>
                </div>
            </div>
        </div>
    </div>

    <form name="answer_form" action="{{route('result')}}" method="post">
            {{ csrf_field() }}
        <input type="hidden" name="title_id" value="{{$title_id}}">
        <input type="hidden" name="alias" value="{{$alias}}">

        @foreach ($questions as $question)
        <div id="block-{{$question->no}}" >
            @if (($question->no % 10 == 0) && ($question->no != $question_count))
<div class="row justify-content-center" style="margin-bottom:1em;">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body q-card-title alert-info" >
残り
@if ($question->no == intval($question_count/2))
半分（@php echo intval($question_count/2); @endphp 問）
@else
（@php echo ($question_count - $question->no); @endphp 問）
@endif
です
            </div>
        </div>
    </div>
</div>
            @endif
        </div>
        <div class="row justify-content-center" style="margin-bottom:1em;">
            <div class="col-md-12">
            <div class="ss-card card shadow-lg">
                <div class="q-card-header">
                        Q{{$question->no}}／{{$question_count}}
                </div>
                <div class="card-body">
                    <div class="q-card-title">
                        {{$question->title}}
                    </div>
<div style="text-align:center;">
            <div class="btn-group btn-group-toggle btn-group-justified" data-toggle="buttons">
                    @foreach ($question->answers() as $ans)
                    <label id="label-{{$question->no}}-{{$ans->no}}" class="btn btn-outline-primary " style="padding-left:40px;padding-right:40px;margin-right:0.5em;margin-left:0.5em;" onclick="onClickAnswer({{$question->no}},{{$ans->no}},{{$question_count}});">
                        <input type="radio" name="q-{{$question->no}}" value="{{$ans->no}}">
                        {{$ans->answer}}
                    </label>
                    @endforeach
            </div>
        </div> 

                </div>
            </div>
            </div>
        </div>
        @endforeach

        <div class="row justify-content-center" style="margin-bottom:1em;">
                <div class="col-md-12">
                <div class=" card">
                    <div class="card-body text-center">
                        <div class="q-card-end">回答お疲れさまでした</div>
            <input class="btn btn-outline-primary action-button" type="button" value="診断結果を見る" onclick="check_input()" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
