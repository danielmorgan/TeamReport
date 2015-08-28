<html>
    <head>
        <title>TeamReport</title>
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
    </head>
    <body>

        @include('header')

        <div class="container-fluid">
            <div class="row">
                <div id="team-report" class="col-xs-12">
                    <h2 id="loading">Loading...</h2>
                </div>
            </div>
        </div>

        @include('templates/projects')
        @include('templates/project-summary')
        @include('templates/project')

    </body>
</html>
