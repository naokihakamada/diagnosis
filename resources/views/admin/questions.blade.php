@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">診断質問作成</div>

                <div class="card-body">
<a class="btn btn-outline-primary " href="{{route('admin_titles')}}">診断タイトルへ</a>
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
                                <td><a class="btn btn-outline-primary " href="{{route('admin_question_edit', ["title_id"=>$title_id, "no"=>$question->no])}}">編集</a> @if(0)<a class="btn btn-outline-primary " href="">削除</a>@endif</td>
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
                    
@if(0)
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">質問　追加</th>
                        </tr>
                        <tr>
                            <td>質問　内容</td>
                            <td>
                                <input type="text" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td>回答(選択肢)　内容</td>
                            <td>
                                <table width="100%" class="table table-bordered">
                                    <tr>
                                        <td>No</td>
                                        <td>選択肢　内容</td>
                                        <td>タイプAポイント</td>
                                        <td>タイプBポイント</td>
                                        <td>タイプCポイント</td>
                                        <td>タイプDポイント</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" size="30"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" size="30"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                        <td><input type="text" size="5"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="追加"></td>
                        </tr>
                    </table>
                @endif

                    <hr />
                    <a class="btn btn-outline-primary " href="{{route('admin_titles')}}">診断タイトルへ</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
