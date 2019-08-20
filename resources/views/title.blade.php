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

                    @foreach ($titles as $title)
                        <h2><a href="{{route('diagnosis',$title->id)}}" type="button">{{$title->title}}</a></h2>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
