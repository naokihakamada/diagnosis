@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card body-bg" style1="background-color:#f8fafc;border:0px">
                <div class="card-body body-bg" style="padding-top:0;padding-right:0;padding-bottom:5px;">
                    <div class="float-right"><a class="btn btn-outline-primary bg-white" href="javascript:history.back()">戻る</a></div>
                </div>
            </div>
        </div>
    </div>
<!-------------------------->
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card shadow">
            <div class="ss-card-header" style="background-color:{{$result_contents[$my_type]["color"]}};color:black;">
                <h2 class="text-center align-middle card-mark" style="margin-bottom:0;">
                    @if($user_record['name']=="")
                    あなたのコミュニケーションスタイルは
                    @else
                    {{$user_record['name']}}さん のコミュニケーションスタイルは
                    @endif
                </h2>
            </div>
            <div class="card-body float-none" style1="background-color:{{$result_contents[$my_type]["color"]}};">
                <h3 class="text-center" style="margin-bottom:1em;margin-top:1em;">「{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}」</h3>
            </div>
        </div>
    </div>
</div>
<br />
<!------------------------->            
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card shadow">
            <div class="ss-card-header" style="background-color:{{$result_contents[$comm_type]["color"]}};color:black;">
                <h2 class="text-center align-middle card-mark" style="margin-bottom:0;line-height:2em;">「{{$result_contents[$comm_type]['type']}} / {{$result_contents[$comm_type]["name"]}} / {{$result_contents[$comm_type]["kana"]}}」を<br />相手とした際のコミュニケーションの注意点</h2>
            </div>
            <div class="card-body" style1="background-color:{{$result_contents[$comm_type]["color"]}};">
{!!$result_contents[$my_type]["communication"]!!}
            </div>
        </div>
    </div>
</div>
<!------------------------->            
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card body-bg" style1ß="background-color:#f8fafc;border:0px">
            <div class="card-body body-bg" style="padding-top:5px;padding-right:0;padding-bottom:5px;">
                    <div class="float-right"><a class="btn btn-outline-primary bg-white" href="javascript:history.back()">戻る</a></div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
