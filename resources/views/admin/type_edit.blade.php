@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">タイプ</div>

                <div class="card-body">
                    <a class="btn btn-outline-primary " href="{{route('admin_titles')}}">診断タイトルへ</a>
<br /><hr />
<form action="" method="POST">
    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="4" width="10%">タイプ</th>
                            <th width="25%">名称</th>
                            <th width="25%">キーワード</th>
                            <th width="30%">カナ</th>
                        </tr>
                        <tr>
                            <th colspan="3">カラー</th>
                        </tr>
                        <tr>
                            <th colspan="3">コンテンツ</th>
                        </tr>
                        <tr>
                            <th colspan="3">コミュ注意点</th>
                        </tr>

                        @foreach($types as $type)
                            <tr>
                            <td rowspan="4">{{$type->style}}<input type="hidden" name="style" value="{{$type->style}}" ></td>
                                <td><input type="text" name="style-type" value="{{$type->type}}"></td>
                                <td><input type="text" name="style-name" value="{{$type->name}}"></td>
                                <td><input type="text" name="style-kana" size="20" value="{{$type->kana}}"></td>
                            </tr>
                            <tr>
                                <td colspan="4" bgcolor="{{$type->color}}">
                                    <input type="text" name="style-color" value="{{$type->color}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><textarea cols="100" rows="20" name="style-contents">{{$type->contents}}</textarea></td>
                            </tr>
                            <tr>
                                <td colspan="3"><textarea cols="100" rows="20" name="style-communication">{{$type->communication}}</textarea></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">
                                <input type="submit" value="更新する">
                            </td>
                    </tr>
                </table>
                </form>
                    <hr />
                    <a class="btn btn-outline-primary " href="{{route('admin_')}}">メニューへ</a>
                </div>
                
            </div>
        </div>
    </div>

    <form action="{{route('admin_logs')}}" method="post" name="form-action" id="form-action">
            @csrf
            <input type="hidden" id="user_id" name="user_id" value="user_id">
            <input type="hidden" id="form-type" name="form-type" value="form-type">
    </form>
</div>

<script>
    function re_diagnosis(id){
        $("#user_id").val(id);
        $("#form-type").val('1');
        $("#form-action").submit();
    }
    function re_new(id){
        $("#user_id").val(id);
        $("#form-type").val('2');
        $("#form-action").submit();
    }
</script>
@endsection
