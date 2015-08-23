<html>
    <head>
        <title>TeamReport</title>
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
    </head>
    <body>
        <header id="header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="center">
                            <div id="menu-switch">
                                <div>
                                    <div class="burger-icon"></div>
                                </div>
                            </div>
                            <a href="/#projects">
                                <h1 class="visible-xs">TR</h1>
                                <h1 class="hidden-xs">TeamReport</h1>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="menu" class="hidden" data-title="Controls">
            <ul class="list-unstyled">
                <li><a href="#">Generate Report</a></li>
            </ul>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div id="team-report" class="col-xs-12">
                    <h2 id="loading">Loading...</h2>
                </div>
            </div>
        </div>

        <script type="text/html" class="projects" id="template-projects">
        </script>

        <script type="text/html" data-tag="li" class="project-summary col-xs-12 col-sm-6 col-md-4 col-lg-3" id="template-project-summary">
            <a href="/#projects/<%= name %>">
                <div class="info">
                    <h3><%= name %></h3>
                    <span class="id">#<%= id %></span>
                    <p><%= company %></p>
                </div>
                <div class="totals">
                    <span class="used"><%= Math.round(used * 100) / 100 %></span>
                    <span class="divider"> / </span>
                    <span class="budget"><%= Math.round(budget * 100) / 100 %></span>
                    <span class="unit">hrs</span></td>
                </div>
            </a>
        </script>

        <script type="text/html" class="project" id="template-project">
            <div class="col-md-8">
                <canvas id="chart"></canvas>
            </div>
            <aside class="col-md-4 info">
                <h1><a href="/#projects/<%= name %>"><%= name %></a></h1>
                <span class="id"><a href="/#projects/<%= id %>">#<%= id %></a></span>
                <p><%= company %></p>
                <table class="tasklists">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Used</th>
                            <th>Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        <% _.forEach(tasklists, function(tasklist) { %>
                            <tr>
                                <td class="key"><%= tasklist.name %></td>
                                <td><%= Math.round(tasklist.used * 100) / 100 %> <span class="unit">hrs</span></td>
                                <td><%= Math.round(tasklist.budget * 100) / 100 %> <span class="unit">hrs</span></td>
                            </tr>
                        <% }); %>
                    </tbody>
                    <tfoot>
                        <tr class="totals">
                            <td class="key">Totals</td>
                            <td><%= Math.round(used * 100) / 100 %> <span class="unit">hrs</span></td>
                            <td><%= Math.round(budget * 100) / 100 %> <span class="unit">hrs</span></td>
                        </tr>
                    </tfoot>
                </table>
            </aside>
        </script>
    </body>
</html>
