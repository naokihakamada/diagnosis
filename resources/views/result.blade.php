@extends('layouts.app')

@section('content')
<script>
        function go_save(){
            $.cookie('diagnosis', '9', {expires: 300, path:"/"});

            @if(0)
            Cookies.set('diagnosis', "9");
            @endif
        }
</script>
    
<div class="container">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
@if(!$user_result)
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card alert alert-info">
                <div class="card-body ">
        <div>
            <p class="send-title">
    こちらのページへのアクセスIDを送信します。<br />
    メールアドレスを入力してください。
</p>
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
                </div>
            </div>
        </div>
</div>
<br />
<br />

@else

<script>go_save();</script>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card" style="background-color:#f8fafc;border:0px">
            <div class="card-body" style="padding-top:0;padding-right:0;padding-bottom:5px;">
@if($answer_check)
                <div>
                    <button class="float-right"><a href="{{route('user_result', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの診断結果</a></button>
                </div>
@else
                <div>
                    <button class="float-right"><a href="{{route('user_answer', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの回答</a></button>
                </div>
@endif
            </div>
        </div>
    </div>
</div>

@endif
<!--- --->

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card">
            <div class="ss-card-header">
            @if(!$user_result)
            <h2 class="text-center">あなたのコミュニケーションスタイルは</h2>
            @else
            <h2 class="text-center align-middle" style="margin-bottom:0;">{{$user_record['name']}}さん のコミュニケーションスタイルは</h2>
            @endif
            </div>
            <div class="card-body float-none" style="background-color:{{$result_contents[$my_type]["color"]}};">

<h3 class="text-center" style="margin-bottom:1em;margin-top:1em;"><a href="#type{{$my_type}}">「{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}」</a></h3>
            </div>
        </div>
    </div>
</div>

<br />

@if($answer_check)
<!--回答一覧===============-->
@php $question_count = count($questions); @endphp

@foreach ($questions as $question)
<div class="row justify-content-center" style="margin-bottom:1em;">
    <div class="col-md-12">
        <div class="ss-card card">
                    <div class="card-body">
                            <h3 class="card-title">
                                    <table width="100%">
                                        <tr>
                                            <td width="15%">Q{{$question->no}}／{{$question_count}}</td>
                                            <td width="70%">{{$question->title}}</td>
                                            <td><p class="text-center">
                                                @foreach ($question->answers() as $no=>$ans)
                                                    @if($ans->no == substr($user_record['answer'], $question->no-1, 1))
                                                    {{$ans->answer}}
                                                    @endif
                                                @endforeach
                                            </p>
                                            </td>
                                        </tr>
                                    </table>
                                </h3>
                    </div>

        </div>
    </div>
</div>
                    @endforeach
<!-------------------------->
@else
<!--　タイプマトリックス -------------------------->
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card ">
            <div class="card-body float-none">
    
<table width="100%" height="100%" class="table table-bordered" style="margin-bottom:0">
    <tr>
        <td colspan="3" class="rc-block" style="vertical-align: middle;text-align:center;background-color:#c6c6c6">感情を<b>抑制・コントール</b>する傾向</td>
    </tr>
    <tr>
        <td width="10%" class="rc-block" style="vertical-align: middle;text-align:center;background-color:#c6c6c6"><span class="vertical" ><b>受け止める</b>傾向</span></td>
        <td width="80%" style="padding:0">

<table width="100%" height="100%" bgcolor="white" style="border-style: none;">
    <tr>
        <td width="50%" align="center" @if($my_type=='A') bgcolor="{{$result_contents['A']["color"]}}" @endif>
            <table width="70%"  bgcolor="{{$result_contents['A']["color"]}}" style="margin-top:1em;">
                <tr>
                    <td class="text-center rc-block" ><a class="type-non-anchor" href="#typeA"><b>{{$result_contents["A"]["type"]}}<br />{{$result_contents["A"]["name"]}}</b></a></td>
                </tr>
                <tr>
                    <td style="padding:0 1em;" class="text-right rc-block">{{$results["A"]}}</td>
                </tr>
            </table>
        </td>
        <td width="50%" align="center" @if($my_type=='B') bgcolor="{{$result_contents['B']["color"]}}" @endif>
            <table width="70%" bgcolor="{{$result_contents['B']["color"]}}" style="margin-top:1em">
                <tr>
                    <td class="text-center rc-block"><a class="type-non-anchor" href="#typeB"><b>{{$result_contents["B"]["type"]}}<br />{{$result_contents["B"]["name"]}}</b></a></td>
                </tr>
                <tr>
                    <td style="padding:0 1em" class="text-left rc-block">{{$results["B"]}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="50%" align="center" @if($my_type=='C') bgcolor="{{$result_contents['C']["color"]}}" @endif>
            <table width="70%" bgcolor="{{$result_contents['C']["color"]}}" style="margin-bottom:1em">
                <tr>
                    <td style="padding:0 1em" class="text-right rc-block">{{$results["C"]}}</td>
                </tr>
                <tr>
                    <td class="text-center rc-block"><a class="type-non-anchor" href="#typeC"><b>{{$result_contents["C"]["type"]}}<br />{{$result_contents["C"]["name"]}}</b></a></td>
                </tr>
            </table>
        </td>
        <td width="50%" align="center"  @if($my_type=='D') bgcolor="{{$result_contents['D']["color"]}}" @endif>
            <table width="70%" bgcolor="{{$result_contents['D']["color"]}}" style="margin-bottom:1em">
                <tr>
                    <td style="padding:0 1em" class="text-left rc-block">{{$results["D"]}}</td>
                </tr>
                <tr>
                    <td class="text-center rc-block"><a class="type-non-anchor" href="#typeD"><b>{{$result_contents["D"]["type"]}}<br />{{$result_contents["D"]["name"]}}</b></a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        </td>
        <td width="10%" class="rc-block" style="vertical-align: middle;text-align:center;background-color:#c6c6c6"><span class="vertical"><b>主張する</b>傾向</span></td>
    </tr>
    <tr>
        <td colspan="3" class="rc-block" style="vertical-align: middle;text-align:center;background-color:#c6c6c6">感情を<b>表現・主張</b>する傾向</td>
    </tr>
</table>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------->
<br />
@foreach($results as $key=>$value)
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card">
            <a name="type{{$key}}"></a>
        
            <div class="ss-card-header">
                <h3 class="text-center align-middle" style="margin-bottom:0;">
                        @if($key==$my_type)あなたのタイプ<br /><br />@endif
                        {{$result_contents[$key]["type"]}} / {{$result_contents[$key]["name"]}} / {{$result_contents[$key]["kana"]}}<br />の特徴（傾向）は
                </h2>
            </div>

            <div class="card-body float-none" style="background-color:{{$result_contents[$key]["color"]}}">
                {!!$result_contents[$key]["contents"]!!}
                <div class="text-center"><a class="btn btn-info btn-lg active" href="{{route('comm',['type'=>$key, 'alias'=>$alias,])}}">＜このタイプの人を相手とした際のコミュニケーションの注意点＞</a></div>
            </div>
        </div>
    </div>
</div>
<br />
@if($key==$my_type)
<hr /><h2 class="text-center">以下は他のタイプの特徴になります。参考にしてください</h2><hr />
@endif
<br />
@endforeach

                </div>
@endif
            </div>
        </div>
    </div>
</div>
@endsection
