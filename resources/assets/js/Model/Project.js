'use strict';
var TeamReport = TeamReport || {};

var Backbone = require('backbone');

TeamReport.Project = Backbone.Model.extend({
    urlRoot: '/api/v1/projects'
});

module.exports = TeamReport.Project;
