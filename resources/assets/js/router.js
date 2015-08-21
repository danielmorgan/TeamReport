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
        '*notFound':            'notFound',
    },

    notFound: function() {
        this.redirectHome();
    },

    redirectHome: function() {
        this.navigate('/projects', {trigger: true});
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
