@extends('layouts.app')

@section('content')
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

<div><button class="float-right"><a href="javascript:history.back()">戻る</a></button></div>
                    <h2>あなたのコミュニケーションスタイルは</h2>
                    
                    <h3 style="text-align:center"><a href="#type{{$my_type}}">{{$result_contents[$my_type]["type"]}} / {{$result_contents[$my_type]["name"]}} / {{$result_contents[$my_type]["kana"]}}</a></h3>
                    <br />
                    
<h2>{{$result_contents[$my_type]['type']}}を相手とした際のコミュニケーションの注意点</h2>
{!!$result_contents[$my_type]["communication"]!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
