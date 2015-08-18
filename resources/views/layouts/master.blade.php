<html>
    <head>
        <title>TeamReport - @yield('title')</title>
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
    </body>
</html>
