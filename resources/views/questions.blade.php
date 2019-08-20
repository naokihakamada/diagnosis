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

                    @foreach ($questions as $question)
                    <div>
                        <h2>[{{$question->no}}/{{$question_count}}] - {{$question->title}}</h2>
                        <p>
                            <ul>
                            @foreach ($question->answers() as $ans)
                                <li><h3>{{$ans->answer}}</h3></li>
                            @endforeach
                            </ul>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
