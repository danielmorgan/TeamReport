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