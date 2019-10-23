@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="background-color:#f8fafc;border:0px">
                <div class="card-body" style="padding-top:0;padding-right:0;padding-bottom:5px;">
                    <div><button class="float-right"><a href="javascript:history.back()">戻る</a></button></div>
                </div>
            </div>
        </div>
    </div>
<!-------------------------->
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card card">
            <div class="ss-card-header">
                <h2 class="text-center align-middle" style="margin-bottom:0;">
                    @if($user_record['name']=="")
                    あなたのコミュニケーションスタイルは
                    @else
                    {{$user_record['name']}}さん のコミュニケーションスタイルは
                    @endif
                </h2>
            </div>
            <div class="card-body float-none" style="background-color:{{$result_contents[$my_type]["color"]}};">
                <h3 class="text-center" style="margin-bottom:1em;margin-top:1em;">「{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}」</h3>
            </div>
        </div>
    </div>
</div>
<br />
<!------------------------->            
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ss-card ccard">
            <div class="ss-card-header">
                <h2 class="text-center align-middle" style="margin-bottom:0;">「{{$result_contents[$comm_type]['type']}} / {{$result_contents[$comm_type]["name"]}} / {{$result_contents[$comm_type]["kana"]}}」を<br />相手とした際のコミュニケーションの注意点</h2>
            </div>
            <div class="card-body" style="background-color:{{$result_contents[$comm_type]["color"]}};">
{!!$result_contents[$my_type]["communication"]!!}
            </div>
        </div>
    </div>
</div>
<!------------------------->            
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card" style="background-color:#f8fafc;border:0px">
            <div class="card-body" style="padding-top:5px;padding-right:0;padding-bottom:5px;">
                <div><button class="float-right"><a href="javascript:history.back()">戻る</a></button></div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
