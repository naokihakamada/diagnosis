@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">タイプ</div>

                <div class="card-body">
                    <a href="{{route('admin_titles')}}">診断タイトルへ</a>
<br /><hr />
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="3" width="10%">タイプ</th>
                            <th width="20%">名称</th>
                            <th width="20%">キーワード</th>
                            <th width="30%">カナ</th>
                            <th width="10%">アクション</th>
                        </tr>
                        <tr>
                            <th colspan="4">カラー</th>
                        </tr>
                        <tr>
                            <th colspan="2">コンテンツ</th>
                            <th colspan="2">コミュ注意点</th>
                        </tr>

                        @foreach($types as $type)
                            <tr>
                                <td rowspan="3">{{$type->style}}</td>
                                <td>{{$type->type}}</td>
                                <td>{{$type->name}}</td>
                                <td>{{$type->kana}}</td>
                                <td><a href="#" onclick="re_diagnosis({{$type->id}});">編集</a></td>
                            </tr>
                            <tr>
                                <td colspan="4" bgcolor="{{$type->color}}">
                                    {{$type->color}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">@php echo htmlspecialchars(mb_substr($type->contents,0,200))."..."; @endphp</td>
                                <td colspan="2">@php echo htmlspecialchars(mb_substr($type->communication,0,200))."..."; @endphp</td>
                            </tr>
                        @endforeach
                    </table>

                    <hr />
                    <a href="{{route('admin_')}}">メニューへ</a>
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
