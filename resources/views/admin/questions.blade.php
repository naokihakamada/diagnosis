@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">診断質問作成</div>

                <div class="card-body">
<a href="{{route('admin_titles')}}">診断タイトルへ</a>
<br /><hr />
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>質問内容/選択肢</th>
                            <th>アクション</th>
                        </tr>

                        @foreach($questions as $question)
                            <tr>
                                <td rowspan="2">{{$question->no}}</td>
                                <td>{{$question->title}}</td>
                                <td><a href="{{route('admin_questions', ["title_id"=>$question->id])}}">編集</a> <a href="">削除</a></td>
                            </tr>
                            <tr>
                                    <td>
                                        <table>
                                        @foreach($question->answers() as $ans)
                                            <tr>
                                                <td>{{$ans->no}}</td>
                                                <td>{{$ans->answer}}</td>
                                                <td>{{$ans->blockA_value}}</td>
                                                <td>{{$ans->blockB_value}}</td>
                                                <td>{{$ans->blockC_value}}</td>
                                                <td>{{$ans->blockD_value}}</td>
                                            </tr>
                                        @endforeach
                                        </table>
                                    </td>
                                    <td></td>
                            </tr>
                        @endforeach
                    </table>

                    <hr />
                    <a href="{{route('admin_titles')}}">診断タイトルへ</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
