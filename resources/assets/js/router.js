'use strict';
var TeamReport = TeamReport || {};

var Backbone = require('backbone');
TeamReport.Projects = require('./Model/Projects.js');
TeamReport.Project = require('./Model/Project.js');
TeamReport.ProjectsView = require('./View/ProjectsView.js');
TeamReport.ProjectView = require('./View/ProjectView.js');

TeamReport.Workspace = Backbone.Router.extend({
    routes: {
        '':                     'projects',
        'projects':             'projects',
        'project/:id':          'project',
        '*notFound':            'notFound',
    },

    notFound: function() {
        console.error('Error: 404 - View not found.');
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
