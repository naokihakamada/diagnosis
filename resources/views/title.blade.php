@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="ss-card card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

<div class="top-paragraph">
コミュニケーションのスタイルには、大きく分けて４つのスタイルがあります。<br />
これは、もともと持って生まれたものではありますが、職種や職場の環境、職位や役割によっても変化します。
</div>
<div class="top-paragraph top-main">
まずは今の自分のスタイルが何なのか？を把握しましょう。
</div>
<div class="top-paragraph">
各タイプの特徴や対応方法も記載してあります。<br />
たとえ苦手なタイプが相手だったとしても、「どのように接すればよいか」が分かれば、人間関係の構築もスムーズになるでしょうし、部下や上司との面談もしやすくなると思います。<br />
初対面のコミュニケーションでも自信を持って対応できると思いますので、ぜひ、営業や接客にも役立てて頂きたいと思います。
</div>

                    <h3 class="go-diagnosis"><a class="btn btn-outline-primary " href="{{route('diagnosis','shindan')}}" >診断を開始する</a></h3>



                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>

@endsection
