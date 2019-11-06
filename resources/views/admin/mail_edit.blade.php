@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">送信メール編集({{$title}})</div>

                <div class="card-body mx-auto">
                    @if (session('status'))
                        <div class="alert alert-{{ session('alert_type') }}" role="alert">
                            【処理結果】<br />
                            {!! session('status') !!}
                        </div>
                    @endif

                    <div><button onclick="javascript:window.location='{{route('admin_mail_test')}}/{{$id}}'">一覧に戻る</button></div>
                    <form method="POST" action="{{ route('admin_mail_edit') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="hidden" name="action" value="save">
                        </div>
                    <br />
                        
                    <table class="table table-bordered table-striped">
                            <tr>
                                <td>送信元</td>
                                <td><input type="text" class="form-control" name="from_name" id="from_name" size="30" value="{{$from_to[0][0]}}" required readonly></td>
                                <td><input type="text" class="form-control" name="from_address" id="from_address" size="50" value="{{$from_to[0][1]}}" required readonly></td>
                            </tr>
                            <tr>
                                <td>送信先</td>
                                <td colspan="2">{{$from_to[1]}}</td>
                            </tr>
                    </table>

                    <div class="tab-content" style="margin-top:1em;">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>件名</td>
                                    <td>
                                        <input type="text" class="form-control" name="subject" id="subject" size="90" value="{{$email[1]}}" required readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>本文</td>
                                    <td><textarea class="form-control" id="body" name="body" cols="100" rows="20" required>{!!$email[2]!!}</textarea></td>
                                </tr>
                            </table>
                    </div>

                    <button type="submit">保存する</button>

                    </form>
                </div>                        
            </div>
        </div>
    </div>
</div>


@endsection
