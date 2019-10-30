<html>
    <body>
        <form method="post" action="{{route('clear')}}">
            @csrf
            <input type="input" name="pass" value="">
            <input type="submit" value="送信">
        </form>
    </body>
</html>