@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ログ確認</div>

                <div class="card-body">
<a class="button" href="{{route('admin_')}}">メニューへ</a>　
<a class="button" href="./">再描画</a>
<br /><hr />
                    <table class="table table-bordered ">
                        <tr bgcolor="gray"  style="color:white">
                            <th rowspan="2">id</th>
                            <th>メールアドレス<br />最終更新日時</th>
                            <th>お名前</th>
                            <th>アクセスID</th>
                            <th>診断タイトル</th>
                            <th>タイプ</th>
                            <th></th>
                        </tr>
                        <tr  bgcolor="gray"  style="color:white">
                            <th colspan="6">
                                各ページ遷移時間（ホームー＞設問表示・回答開始ー＞回答終了ー＞登録ー＞診断確認）
                            </th>
                        </tr>

                        @foreach($logs as $log)
                            <tr @if($loop->iteration%2==0) bgcolor="lightgray" @endif>
                                <td rowspan="2">{{$log->id}}</td>
                                <td>{{$log->email}}<br />{{$log->updated_at}}</td>
                                <td>{{$log->name}}</td>
                                <td><a href="{{route('user_result',['access_id'=>$log->access_id, 'alias'=>$log->alias,])}}">{{$log->access_id}}</a></td>
                                <td>{{$log->alias}}</td>
                                <td>{{$log->my_type}}</td>
                                <td><a href="#" onclick="re_diagnosis({{$log->id}});">リセット</a><br /><a href="#" onclick="del_diagnosis({{$log->id}})">削除</a></td>
                            </tr>
                            <tr @if($loop->iteration%2==0) bgcolor="lightgray" @endif>
                                <td colspan="6">
                                    <table width="100%" @if($loop->iteration%2==0) bgcolor="lightgray" @endif>
                                        <tr>
                                            <td width="25%">{{$log->p1}}</td>
                                            <td width="25%">{{$log->p2}}@if(!is_null($log->p2)) ({{$log->pp2}}秒) @endif</td>
                                            <td width="25%">{{$log->p3}}</td>
                                            <td width="25%">{{$log->p4}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $logs->links() }}

                    <hr />
                    <a class="button" href="{{route('admin_')}}">メニューへ</a>
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
        if(confirm("再診断用にデータをリセットします。よろしいですか？")){
            $("#user_id").val(id);
            $("#form-type").val('1');
            $("#form-action").submit();
            return true;
        }else{
            return false;
        }
    }
    function del_diagnosis(id){
        if(confirm("レコードを削除します。よろしいですか？")){
            $("#user_id").val(id);
            $("#form-type").val('2');
            $("#form-action").submit();
            return true;
        }else{
            return false;
        }
    }
</script>
@endsection
