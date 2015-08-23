'use strict';
var TeamReport = TeamReport || {};

var $ = require('jquery');
var Backbone = require('backbone');
TeamReport.Projects = require('./Model/Projects.js');
TeamReport.Project = require('./Model/Project.js');
TeamReport.ProjectsView = require('./View/ProjectsView.js');
TeamReport.ProjectView = require('./View/ProjectView.js');

TeamReport.Workspace = Backbone.Router.extend({
    routes: {
        '':                     'redirectHome',
        'projects':             'projects',
        'projects/:id':         'project',
        '*notFound':            'redirectHome',
    },

    initialize: function() {
        // Override default anchor behaviour, and replace it 
        // with Backbone.history.navigate()
        $(document).on('click', 'a:not([data-bypass])', function(event) {
            var href = {
                prop: $(this).prop('href'),
                attr: $(this).attr('href')
            };
            var root = location.protocol + '//' + location.host + TeamReport.root;
            if (href.prop && href.prop.slice(0, root.length) === root) {
                event.preventDefault();
                this.navigate(href.attr, true);
            }
        });
    },

    redirectHome: function() {
        this.navigate('/projects', { trigger: true });
    },

    projects: function() {
        var projects = new TeamReport.Projects();
        new TeamReport.ProjectsView({ collection: projects });
    },

    project: function(id) {
        var project = new TeamReport.Project({ id: id });
        new TeamReport.ProjectView({ model: project });
    }
});

module.exports = TeamReport.Workspace;
