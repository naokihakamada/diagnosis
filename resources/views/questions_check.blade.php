@extends('layouts.app')

@section('content')
<script>
    function go_result(){
        Cookies.set('diagnosis', "1");
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
        <div class="card">
                    <input type="hidden" name="q-{{$question->no}}" value="{{$checks[$question->no]}}">
                    <div class="card-body">
                            <h3 class="card-title">
                                    <table width="100%">
                                        <tr>
                                            <td width="15%">Q{{$question->no}}／{{$question_count}}</td>
                                            <td width="70%">{{$question->title}}</td>
                                            <td><p class="text-center">
                                                @foreach ($question->answers() as $no=>$ans)
                                                    @if($ans->no == $checks[$question->no])
                                                    {{$ans->answer}}
                                                    @endif
                                                @endforeach
                                            </p>
                                            </td>
                                        </tr>
                                    </table>
                                </h3>
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
