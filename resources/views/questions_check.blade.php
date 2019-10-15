@extends('layouts.app')

@section('content')
<script>
    function go_result(){
        Cookies.set('diagnosis', "1");
    }
</script>

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

                    <form name="answer_form" action="{{route('result')}}" method="post">
                        {{ csrf_field() }}
                    <input type="hidden" name="title_id" value="{{$title_id}}">
                    <input type="hidden" name="alias" value="{{$alias}}">
                    @foreach ($questions as $question)
                    <input type="hidden" name="q-{{$question->no}}" value="{{$checks[$question->no]}}">
                    <div>
                        <h2>[{{$question->no}}/{{$question_count}}] - {{$question->title}}</h2>
                        <p>
                            <ul>
                            
                            @foreach ($question->answers() as $no=>$ans)
                                @if($ans->no == $checks[$question->no])
                                <li><h3>{{$ans->answer}}</h3></li>
                                @endif
                            @endforeach
                            </ul>
                        </p>
                    </div>
                    @endforeach

                    <input type="submit" value="診断結果へ"  onclick="go_result()" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
