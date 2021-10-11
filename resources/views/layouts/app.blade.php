<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Business information @yield('title')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('css/app.css')}}">
        <script src="{{ mix('js/app.js')}}" async defer></script>
    </head>
    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadom-sm mb-3">
            <h5 class="my-0 mr-md-auto" font-weight-normal> Laravel App </h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a href="{{ route('home.index') }}" class="p-2 text-dark">Home</a>
                <a href="{{ route('home.contact') }}" class="p-2 text-dark">Contact</a>
                <a href="{{ route('posts.index') }}" class="p-2 text-dark">Blog Posts</a>
                <a href="{{ route('posts.create') }} " class="p-2 text-dark">Add Blog Post</a>
            </nav>
        </div>
        
        <div>
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            @yield('content')
        </div>
    </body>
</html>