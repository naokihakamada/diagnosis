@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">診断タイトル</div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="15%">アクセスキー名</th>
                            <th width="30%">タイトル</th>
                            <th width="35%">コメント</th>
                            <th width="20%">アクション</th>
                        </tr>
                        <tr>
                    @foreach($titles as $title)
                            <td>{{$title->alias}}</td>
                            <td>{{$title->title}}</td>
                            <td>{{$title->contents}}</td>
                            <td>
                                <a class="btn btn-outline-primary " href="{{route('admin_questions', ["title_id"=>$title->id])}}">質問へ</a>&nbsp;
                                <a class="btn btn-outline-primary " href="{{route('admin_types', ["title_id"=>$title->id])}}">タイプへ</a><br />
                                <hr />
                                <a class="btn btn-outline-primary " href="">編集</a>&nbsp;
                                @if (0) <a class="btn btn-outline-primary " href="">削除</a> @endif
                            </td>
                    @endforeach
                        </tr>
                    </table>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection
