'use strict';
var TeamReport = TeamReport || {};

var Backbone = require('backbone');
TeamReport.Workspace = require('./router.js');

new TeamReport.Workspace();
Backbone.history.start({ pushState: true });
