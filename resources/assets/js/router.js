'use strict';
var TeamReport = TeamReport || {};

var Backbone = require('backbone');

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
        console.log('projects');
    },

    project: function(id) {
        console.log('project', id);
    }
});

module.exports = TeamReport.Workspace;
