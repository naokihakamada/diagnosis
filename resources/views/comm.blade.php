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
        <div class="card">
            <div class="card-header">
                <h2 class="text-center align-middle" style="margin-bottom:0;">{{$user_record['name']}}さん のコミュニケーションスタイルは</h2>
            </div>
            <div class="card-body float-none" style="background-color:{{$result_contents[$my_type]["color"]}};">
                <h3 class="text-center" style="margin-bottom:1em;margin-top:1em;"><a href="#type{{$my_type}}">「{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}」</a></h3>
            </div>
        </div>
    </div>
</div>
<br />
<!------------------------->            
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center align-middle" style="margin-bottom:0;">{{$result_contents[$my_type]['type']}}を相手とした際のコミュニケーションの注意点</h2>
            </div>
            <div class="card-body">
{!!$result_contents[$my_type]["communication"]!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
