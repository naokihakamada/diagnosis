@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">診断タイトル作成</div>

                <div class="card-body">

                    <table class="table table-striped">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="35%">タイトル</th>
                            <th width="35%">コメント</th>
                            <th width="20%">アクション</th>
                        </tr>
                        <tr>
                    @foreach($titles as $title)
                            <td>{{$title->alias}}</td>
                            <td>{{$title->title}}</td>
                            <td>{{$title->contents}}</td>
                            <td>
                                <a href="{{route('admin_questions', ["title_id"=>$title->id])}}">質問へ</a><br />
                                <a href="{{route('admin_types', ["title_id"=>$title->id])}}">タイプへ</a><br />
                                <a href="">編集</a><br />
                                <a href="">削除</a>
                            </td>
                    @endforeach
                        </tr>
                    </table>

                    <br />
                    <a href="">新規追加</a>
                </div>

            </div>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top:1em">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success">診断タイトル新規作成</div>

                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
