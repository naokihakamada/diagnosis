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

        document.answer_form.submit();
    }

    var answers="";
    $(document).ready( function(){
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

        //回答の再現
        for(i=0;i<answers.length;i++){
            var v = answers.substr(i,1);
            if(v != "0"){
                $("input[name=q-"+(i+1)+"]").val([v]);
            }
        }
    });

    function onClickAnswer(no,ans){
        var l = answers.substr(0,no-1);
        var r = answers.substr(no);
        answers = l + ans + r;
        console.log(answers);
        Cookies.set('answers', answers);
    }
 </script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form name="answer_form" action="{{route('check')}}" method="post">
                        {{ csrf_field() }}
                    <input type="hidden" name="title_id" value="{{$title_id}}">
                    <input type="hidden" name="alias" value="{{$alias}}">
                    @foreach ($questions as $question)
                    <div>
                        <h2>[{{$question->no}}/{{$question_count}}] - {{$question->title}}</h2>
                        <p>
                            <ul>
                            @foreach ($question->answers() as $ans)
                                <li><h3><input type="radio" name="q-{{$question->no}}" value="{{$ans->no}}" onclick="onClickAnswer({{$question->no}},{{$ans->no}});">{{$ans->answer}}</h3></li>
                            @endforeach
                            </ul>
                        </p>
                    </div>
                    @endforeach

                    <input type="button" value="診断結果へ" onclick="check_input()" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
