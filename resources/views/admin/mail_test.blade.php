@extends('layouts.admin')

@section('content')
<script>
    function sendMe(no){
        if(confirm('テスト送信したします。よろしいですか')){
            $.ajax({
                url         : '{{ route('admin_send_test') }}',
                type        : 'post',
                dataType    : 'json',
                data        : {
                    _token: '{{ csrf_token() }}',
                    id    : no
                }
            })
            .done(function(response) {
                console.log(response);

                if(response['code'] == 'OK') {
                //処理
                    alert(response['message']);
                } else {
                    alert('エラー');
                }
            })
            .fail(function(response) {
                alert('fail エラー');
            });
        }

        return false;
    }
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">送信メール編集</div>

                <div class="card-body mx-auto">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            【処理結果】<br />
                            {!! session('status') !!}
                        </div>
                    @endif

                    <table class="table table-bordered ">
                            <tr>
                                <td></td>
                                <td>{{$app_name}}</td>
                            <td rowspan="2"><a href="{{route('admin_')}}">メニューへ</a></td>
                            </tr>
                            <tr>
                                <td>送信元</td>
                                <td>{{$from_to[0]}}</td>
                            </tr>
                    </table>
                    <table class="table table-bordered table-striped">
                            <tr>
                                <td>送信先</td>
                                <td colspan="2">{{$from_to[1]}}</td>
                            </tr>
                    </table>

                    <ul class="nav nav-tabs  nav-justified">
                        <li class="nav-item">
                            <a href="#tab1" class="nav-link @if($pos==1) active @endif" data-toggle="tab">アクセスID</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top:1em;">
                        @foreach($emails as $email)
                        <div id="tab{{$loop->iteration}}" class="tab-pane @if($loop->iteration==$pos) active @endif">
                            <div>
                                <form method="POST" action="{{ route('admin_mail_edit') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$loop->iteration}}">
                                    <button onclick="return sendMe({{$loop->iteration}});">自分に送信する</button>
                                    <button type="submit">編集する</button>
                                </form>
                            </div>
                            <br />
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>件名</td>
                                    <td>{{$email[0]}}</td>
                                </tr>
                                <tr>
                                    <td>本文</td>
                                    <td>{!!$email[1]!!}</td>
                                </tr>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>


@endsection
