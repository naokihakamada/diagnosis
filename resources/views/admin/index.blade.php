@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">管理画面</div>

                <div class="card-body">

                    <ul>
                        <li>
                        <a href="{{ route('admin_titles')}}">診断タイトル</a>
                        </li>
                        <li>
                            <a href="{{ route('admin_mail_test')}}">送信メール編集</a>
                        </li>
                        <li>
                            <a href="{{ route('admin_logs')}}">ログ確認</a>
                            </li>
                        </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
