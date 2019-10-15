@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">管理画面</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post">
                        <textarea id="mytextarea" name="mytextarea">Hello, World!</textarea>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
