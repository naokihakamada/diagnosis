@extends('layouts.app')

@section('content')
<script>
        function go_save(){
            $.cookie('diagnosis', '9', {expires: 300, path:"/"});
            //alert('cookie');

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
            <div class="ss-card card shadow">
                <div class="card-body ">
        <div class="ss-card-header text-center" style="font-size:1.25em">
    診断結果ページへのアクセスIDを送信します。<br />
    お名前とメールアドレスを入力してください。<br />
        </div>

    <form name="access_form" method="post" action="{{ route('save') }}" style="margin-top:1.5em">
        @csrf
        <input type="hidden" name="title_id" value="{{ $title_id }}">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">お名前</label>
                <div class="col-md-4">
                        <input id="name" name="name" type="text" placeholder="例) 東京　花子" autocomplete="name" size="30" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                <div class="col-md-4">
                        <input id="email" name="email" type="email" placeholder="例) taro@hanako.com" autocomplete="email" size="30" required>
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
        <div class="card body-bg" >
            <div class="card-body body-bg" style="padding-top:0;padding-right:0;padding-bottom:1em;">
@if($answer_check)
                <div>
                    <div class="float-right"><a class="btn btn-outline-primary bg-white" href="{{route('user_result', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの診断結果を見る</a></div>
                </div>
@else
                <div>
                    <div class="float-right"><a class="btn btn-outline-primary bg-white" href="{{route('user_answer', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの回答を見る</a></div>
                </div>
@endif
            </div>
        </div>
    </div>
</div>

<!--- --->

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card shadow">
            <div class="ss-card-header" style="background-color:white ;color:black;">
            @if(!$user_result)
            <h2 class="text-center">あなたのコミュニケーションスタイルは</h2>
            @else
            <h2 class="text-center align-middle card-mark" style="margin-bottom:0;">{{$user_record['name']}}さん のコミュニケーションスタイルは</h2>
            @endif
            </div>
            <div class="card-body float-none" style="background-color1:{{$result_contents[$my_type]["color"]}};">

<h3 class="text-center" style="margin-bottom:1em;margin-top:1em;"><mark style="line-height:1.5em;background-color:{{$result_contents[$my_type]["color"]}};><a style="color:black" href="#type{{$my_type}}">「{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}」</a></mark></h3>
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
        <div class=" ss-card card ">
                    <div class="q-card-header">
                            Q{{$question->no}}／{{$question_count}}
                    </div>
                    <div id="block-{{$question->no}}" class="card-body">
                        <div class="q-card-title">
                            {{$question->title}}
                        </div>

                                            <div class="text-center q-check-ans">
                                                    @foreach ($question->answers() as $no=>$ans)
                                                    @if($ans->no == substr($user_record['answer'], $question->no-1, 1))
                                                    <label class="btn active btn-outline-primary">{{$ans->answer}}</label>
                                                    @endif
                                                @endforeach
                                            </div>
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
        <div class="ss-card card shadow">
            <div class="card-body float-none" style="padding:0;">
    
<table width="100%" height="100%" class="table table-bordered" style="margin-bottom:0">
    <tr>
        <td colspan="3" class="rc-block @php if(in_array($my_type,array('A','B'))) echo 'blinking' @endphp" style="vertical-align: middle;text-align:center;background-color:#c6c6c6">感情を<b>抑制・コントール</b>する傾向</td>
    </tr>
    <tr>
        <td width="10%" class="rc-block  @php if(in_array($my_type,array('A','C'))) echo 'blinking' @endphp" style="vertical-align: middle;text-align:center;background-color:#c6c6c6"><span class="vertical" style="height:100%"><b>受け止める</b>傾向</span></td>
        <td width="80%" style="padding:0">

<table width="100%" height="100%" bgcolor="white" style="border-style: none;border:0px;overflow:visible">
    <tr>
        <td width="50%" align="center" bgcolor="{{$result_contents['A']["color"]}}" @if($my_type=='A') class="shadow-lg blinking" @endif>
            <table width="70%" @if($my_type=='A') bgcolor="{{$result_contents['A']["color"]}}" @endif style="margin-top:1em;">
                <tr>
                    <td class="text-center rc-block" ><a class="type-non-anchor" href="#typeA"><b>{{$result_contents["A"]["type"]}}<br />{{$result_contents["A"]["name"]}}</b></a></td>
                </tr>
                <tr>
                    <td style="padding:0 1em;" class="text-right rc-block">{{$results["A"]}}</td>
                </tr>
            </table>
        </td>
        <td width="50%" align="center" bgcolor="{{$result_contents['B']["color"]}}" @if($my_type=='B') class="shadow-lg blinking" @endif>
            <table width="70%" @if($my_type=='B') bgcolor="{{$result_contents['B']["color"]}}"@endif style="margin-top:1em">
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
        <td width="50%" align="center" bgcolor="{{$result_contents['C']["color"]}}" @if($my_type=='C') class="shadow-lg blinking" @endif>
            <table width="70%" @if($my_type=='C') bgcolor="{{$result_contents['C']["color"]}}"@endif style="margin-bottom:1em">
                <tr>
                    <td style="padding:0 1em" class="text-right rc-block">{{$results["C"]}}</td>
                </tr>
                <tr>
                    <td class="text-center rc-block"><a class="type-non-anchor" href="#typeC"><b>{{$result_contents["C"]["type"]}}<br />{{$result_contents["C"]["name"]}}</b></a></td>
                </tr>
            </table>
        </td>
        <td width="50%" align="center"  bgcolor="{{$result_contents['D']["color"]}}" @if($my_type=='D') class="shadow-lg blinking" @endif>
            <table width="70%" @if($my_type=='D') bgcolor="{{$result_contents['D']["color"]}}"@endif style="margin-bottom:1em">
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
        <td width="10%" class="rc-block @php if(in_array($my_type,array('B','D'))) echo 'blinking' @endphp" style="vertical-align: middle;text-align:center;background-color:#c6c6c6"><span class="vertical"><b>主張する</b>傾向</span></td>
    </tr>
    <tr>
        <td colspan="3" class="rc-block @php if(in_array($my_type,array('C','D'))) echo 'blinking' @endphp" style="vertical-align: middle;text-align:center;background-color:#c6c6c6">感情を<b>表現・主張</b>する傾向</td>
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
        <div class="ss-card card shadow">
            <a name="type{{$key}}"></a>
        
            <div class="ss-card-header" style="background-color:{{$result_contents[$key]["color"]}};color:black;">
                <h3 class="text-center align-middle" style="margin-bottom:0;">
                        @if($key==$my_type)あなたのタイプ<br /><br />@endif
                        {{$result_contents[$key]["type"]}} / {{$result_contents[$key]["name"]}} / {{$result_contents[$key]["kana"]}}<br /><br />の特徴（傾向）は
                </h2>
            </div>

            <div class="card-body float-none" style="background-color1:{{$result_contents[$key]["color"]}}">
                {!!$result_contents[$key]["contents"]!!}
                <div class="text-center">
                    <a class="btn btn-info btn-lg active blinking" href="{{route('comm',['type'=>$key, 'alias'=>$alias,])}}">《このタイプの相手と接する時の注意点を見る》</a></div>
            </div>
        </div>
    </div>
</div>
<br />
@if($key==$my_type)
<hr /><h2 class="text-center">以下、他の３タイプの特徴です。<br />接する際の注意点もぜひ、ご参考ください。</h2><hr /><br />
@endif
@endforeach

@endif

    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card body-bg">
                    <div class="card-body body-bg" style="padding-top:0;padding-right:0;padding-bottom:5px;">
        @if($answer_check)
                        <div>
                            <div class="float-right"><a class="btn btn-outline-primary bg-white" href="{{route('user_result', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの診断結果を見る</a></div>
                        </div>
        @else
                        <div>
                            <div class="float-right"><a class="btn btn-outline-primary bg-white" href="{{route('user_answer', ['alias'=>$user_record['alias'], 'access_id'=>$user_record['access_id']])}}">あなたの回答を見る</a></div>
                        </div>
        @endif
                    </div>
                </div>
            </div>
        </div>
@endif
</div>
</div>
</div>
</div>

</div>
@endsection
