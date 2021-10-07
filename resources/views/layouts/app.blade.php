<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Business information @yield('title')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <div>
            @if(session('status'))
            <div style="background: red; color: white">
                {{session('status')}}
            </div>
            @endif
            @yield('content')
        </div>
        <script src="" async defer></script>
    </body>
</html>