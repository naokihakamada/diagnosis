@extends('layouts.app')

@section('content')
<script>
    function go_result(){
        $.cookie('diagnosis', '1', {expires: 300, path:"/"});

        @if(0)
        Cookies.set('diagnosis', "1");
        @endif
    }
</script>

<div class="container">

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
<div class="row justify-content-center" style="margin-bottom:1em;">
    <div class="col-md-12">
        <div class=" ss-card card">
                    <input type="hidden" name="q-{{$question->no}}" value="{{$checks[$question->no]}}">
                    <div class="q-card-header">
                            Q{{$question->no}}／{{$question_count}}
                    </div>
                    <div id="block-{{$question->no}}" class="card-body">
                        <div class="q-card-title">
                            {{$question->title}}
                        </div>

                                            <div class="text-center q-check-ans">
                                                @foreach ($question->answers() as $no=>$ans)
                                                    @if($ans->no == $checks[$question->no])
                                                    {{$ans->answer}}
                                                    @endif
                                                @endforeach
                                            </div>
                    </div>

        </div>
    </div>
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
