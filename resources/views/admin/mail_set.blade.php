@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('AdminMailTest')}}</div>

                <div class="card-body mx-auto">
                    @if (session('status'))
                        <div class="alert alert-{{ session('alert_type')}}" role="alert">
                            【処理結果】<br />
                            {!! session('status') !!}
                        </div>
                    @endif

                    <div><button onclick='javascript:window.location="{{route('admin_mail_test')}}"'>一覧に戻る</button></div><br />
                    <form method="POST" action="{{ route('admin_mail_set') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="action" value="save">
                    <table class="table table-bordered ">
                            <tr>
                                <td >システム名<br />(件名プレフィックス)</td>
                                <td colspan="2"><input type="text" class="form-control" class="form-control" name="app_name" id="app_name" value="{{$app_name}}" required></td>
                            <td rowspan="2"><button type="submit">保存する</button></td>
                            </tr>
                            <tr>
                                <td>送信元</td>
                                <td>
                                    <input type="text" class="form-control" name="sender_name" id="sender_name" value="{{$from_to[0][0]}}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="sender_address" id="sender_address" size="30" value="{{$from_to[0][1]}}" autocomplete="email" required>
                                </td>
                            </tr>
                    </table>
                    </form>

                    <table class="table table-bordered table-striped">
                            <tr>
                                <td>送信先</td>
                                <td colspan="2">{{$from_to[1]}}</td>
                            </tr>
                    </table>

                </div>                        
            </div>
        </div>
    </div>
</div>


@endsection
