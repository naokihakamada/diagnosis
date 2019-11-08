@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">診断質問作成</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <a class="btn btn-outline-primary " href="{{route('admin_titles')}}">診断タイトルへ</a>&nbsp;<a class="btn btn-outline-primary " href="{{route('admin_questions', ["title_id"=>$title_id])}}">質問へ</a>
<br /><hr />
<form action="{{route('admin_question_edit', ["title_id"=>$title_id, "no"=>$no,])}}" method="POST">
    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>質問内容/選択肢</th>
                        </tr>

                        @foreach($questions as $question)
                            <tr>
                                <td rowspan="2">{{$question->no}}<input type="hidden" name="no" value="{{$question->no}}"></td>
                                <td><input name="question_title" type="text" size="80" value="{{$question->title}}"></td>
                            </tr>
                            <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <th>No</th>
                                                <th>選択肢</th>
                                                <th>タイプA</th>
                                                <th>タイプB</th>
                                                <th>タイプC</th>
                                                <th>タイプD</th>
                                            </tr>
                                        @foreach($question->answers() as $ans)
                                            <tr>
                                                <td>{{$ans->no}}<input type="hidden" name="ano-{{$ans->no}}" value="{{$ans->no}}"></td>
                                                <td><input type="text" name="ano-{{$ans->no}}-answer" value="{{$ans->answer}}"></td>
                                                <td><input type="text" size="5" name="ano-{{$ans->no}}-A" value="{{$ans->blockA_value}}"></td>
                                                <td><input type="text" size="5" name="ano-{{$ans->no}}-B" value="{{$ans->blockB_value}}"></td>
                                                <td><input type="text" size="5" name="ano-{{$ans->no}}-C" value="{{$ans->blockC_value}}"></td>
                                                <td><input type="text" size="5" name="ano-{{$ans->no}}-D" value="{{$ans->blockD_value}}"></td>
                                            </tr>
                                        @endforeach
                                        </table>
                                    </td>
                            </tr>
                        @endforeach
                        <tr>
                                <td colspan="2">
                                    <input type="submit" value="更新する">
                                </td>
                        </tr>
                    </table>
                    
                </form>

                    <hr />
                    <a class="btn btn-outline-primary " href="{{route('admin_titles')}}">診断タイトルへ</a>&nbsp;<a class="btn btn-outline-primary " href="{{route('admin_questions', ["title_id"=>$title_id])}}">質問へ</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
