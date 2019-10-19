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
                        <a href="{{ route('admin_titles')}}">診断タイトル作成</a>
                        </li>
                        <li>
                            <a href="{{ route('admin_logs')}}">アクセスログ</a>
                            </li>
                        </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
