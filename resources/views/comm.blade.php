@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
<h2>{{$result["type"]}}を相手とした際のコミュニケーションの注意点</h2>
{!!$result["comm"]!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
