@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ログ確認</div>

                <div class="card-body">
<a href="{{route('admin_')}}">メニューへ</a>
<br /><hr />
                    <table class="table table-bordered">
                        <tr>
                            <th>id</th>
                            <th>メールアドレス</th>
                            <th>お名前</th>
                            <th>アクセスID</th>
                            <th>診断タイトル</th>
                            <th>タイプ</th>
                            <th></th>
                        </tr>

                        @foreach($logs as $log)
                            <tr>
                                <td>{{$log->id}}</td>
                                <td>{{$log->email}}</td>
                                <td>{{$log->name}}</td>
                                <td><a href="{{route('user_result',['access_id'=>$log->access_id, 'alias'=>$log->alias,])}}">{{$log->access_id}}</a></td>
                                <td>{{$log->alias}}</td>
                                <td>{{$log->my_type}}</td>
                                <td><a href="#" onclick="re_diagnosis({{$log->id}});">再診断</a><br /><a href="#" onclick="re_new({{$log->id}})">新規へ</a></td>
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
