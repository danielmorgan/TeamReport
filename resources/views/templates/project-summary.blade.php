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