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
                    <h3>Loading...</h3>
                </div>
            </div>
        </div>

        <script type="text/html" class="projects" id="template-projects">
        </script>

        <script type="text/html" data-tag="li" class="project-summary col-xs-12 col-sm-6 col-md-4 col-lg-3" id="template-project-summary">
            <a href="/#projects/<%= name %>">
                <h3><%= name %></h3>
                <p><%= company %></p>
                <div class="chart"></div>
            </a>
        </script>

        <script type="text/html" class="project" id="template-project">
            <div class="col-sm-6 col-md-8 chart"></div>
            <aside class="col-sm-6 col-md-4 info">
                <h1><%= name %></h1>
                <p><%= company %></p>
                <p><strong>Project ID:</strong> <%= id %></p>
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
                                <td><%= tasklist.used %> <span class="unit">hrs</span></td>
                                <td><%= tasklist.budget %> <span class="unit">hrs</span></td>
                            </tr>
                        <% }); %>
                    </tbody>
                    <tfoot>
                        <tr class="totals">
                            <td class="key">Totals</td>
                            <td><%= used %> <span class="unit">hrs</span></td>
                            <td><%= budget %> <span class="unit">hrs</span></td>
                        </tr>
                    </tfoot>
                </table>
            </aside>
        </script>
    </body>
</html>
