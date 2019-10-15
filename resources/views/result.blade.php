@extends('layouts.app')

@section('content')
<script>
        function go_save(){
            Cookies.set('diagnosis', "9");
            alert('9');
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
@if(!$user_result)
<div>
    このページへのアクセスIDを送信します。<br />
    メールアドレスを入力してください。
    <form name="access_form" method="post" action="{{ route('save') }}">
        @csrf
        <input type="hidden" name="title_id" value="{{ $title_id }}">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">お名前</label>
                <div class="col-md-4">
                        <input id="name" name="name" type="text" placeholder="例) 東京　花子" autocomplete="name" size="50" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                <div class="col-md-4">
                        <input id="email" name="email" type="email" placeholder="例) taro@hanako.com" autocomplete="email" size="50" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-success" onclick="go_save()">送信する</button>
                </div>
            </div>
    </form>
</div>
<br />
<h2>あなたのコミュニケーションスタイルは</h2>
@else
    @if($answer_check)
<div><button class="float-right"><a href="{{route('user_result', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの診断結果</a></button></div>
    @else
<div><button class="float-right"><a href="{{route('user_answer', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの回答</a></button></div>
    @endif
<h2>{{$user_record['name']}}さん のコミュニケーションスタイルは</h2>
@endif

<h3 style="text-align:center"><a href="#type{{$my_type}}">{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}</a></h3>
<br />

@if($answer_check)
@php $question_count = count($questions); @endphp
@foreach ($questions as $question)
<div>
    <h2>[{{$question->no}}/{{$question_count}}] - {{$question->title}}</h2>
    <p>
        <ul>
        
        @foreach ($question->answers() as $no=>$ans)
            @if($ans->no == substr($user_record['answer'], $question->no-1, 1))
            <li><h3>{{$ans->answer}}</h3></li>
            @endif
        @endforeach
        </ul>
    </p>
</div>
@endforeach

@else
                    <table width="100%" height="100%" class="table table-striped">
                        <tr>
                            <td colspan="3" style="vertical-align: middle;text-align:center;">感情を<b>抑制・コントール</b>する傾向</td>
                        </tr>
                        <tr>
                            <td width="25%" style="vertical-align: middle;text-align:center;"><span class="vertical" ><b>受け止める</b>傾向</span></td>
                            <td width="50%">
                                <table width="100%">
                                    <tr>
                                        <td align="center" @if($my_type=="A")bgcolor="red"@endif><b>{{$result_contents["A"]["type"]}}<br />{{$result_contents["A"]["name"]}}<br />（{{$result_contents["A"]["kana"]}}）</b></td>
                                        <td></td>
                                        <td align="center" @if($my_type=="B")bgcolor="red"@endif><b>{{$result_contents["B"]["type"]}}<br />{{$result_contents["B"]["name"]}}<br />（{{$result_contents["B"]["kana"]}}）</b></td>
                                    </tr>
                                    <tr>
                                        <td align="right" @if($my_type=="A")bgcolor="red"@endif>{{$results["A"]}}</td>
                                        <td></td>
                                        <td align="left" @if($my_type=="B")bgcolor="red"@endif>{{$results["B"]}}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" @if($my_type=="C")bgcolor="red"@endif>{{$results["C"]}}</td>
                                        <td></td>
                                        <td align="left" @if($my_type=="D")bgcolor="red"@endif>{{$results["D"]}}</td>
                                    </tr>
                                    <tr>
                                        <td align="center" @if($my_type=="C")bgcolor="red"@endif><b>{{$result_contents["C"]["type"]}}<br />{{$result_contents["C"]["name"]}}<br />（{{$result_contents["C"]["kana"]}}）</b></td>
                                        <td></td>
                                        <td align="center" @if($my_type=="D")bgcolor="red"@endif><b>{{$result_contents["C"]["type"]}}<br />{{$result_contents["C"]["name"]}}<br />（{{$result_contents["C"]["kana"]}}）</b></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="25%" style="vertical-align: middle;text-align:center;"><span class="vertical"><b>主張する</b>傾向</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle;text-align:center;">感情を<b>表現・主張</b>する傾向</td>
                        </tr>
                    </table>

                @foreach($results as $key=>$value)
            <a name="type{{$key}}"></a>
            @if($key==$my_type)
            <br /><br /><h2>あなたのタイプの特徴（傾向）は</h2><br />
            @endif
            <div>
                <h3>{{$result_contents[$key]["type"]}} / {{$result_contents[$key]["name"]}} / {{$result_contents[$key]["kana"]}}　の特徴（傾向）</h3>
                <div>{!!$result_contents[$key]["contents"]!!}</div>
                <div><a href="{{route('comm',['type'=>$key, 'alias'=>$alias,])}}">＜このタイプの人を相手とした際のコミュニケーションの注意点＞</a></div>
            </div>

            @if($key==$my_type)
            <br /><br /><h2>以下は他のタイプの特徴になります。参考にしてください</h2><br />
            @endif
                @endforeach

                </div>
@endif
            </div>
        </div>
    </div>
</div>
@endsection
