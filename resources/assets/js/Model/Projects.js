'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var Backbone = require('backbone');
TeamReport.Project = require('./Project.js');

TeamReport.Projects = Backbone.Collection.extend({
    model: TeamReport.Project,
    url: '/api/v1/projects'
});

module.exports = TeamReport.Projects;
