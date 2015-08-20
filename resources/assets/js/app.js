'use strict';
var TeamReport = TeamReport || {};

var $ = require('jquery');
var Backbone = require('backbone');
TeamReport.Workspace = require('./router.js');

new TeamReport.Workspace();

$(function() {
    Backbone.history.start({ pushState: true });
});
