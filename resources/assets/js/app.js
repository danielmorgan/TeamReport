'use strict';
var TeamReport = TeamReport || {};

window.$ = window.jQuery = require('jquery');
var Backbone = require('backbone');
require('../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js');
TeamReport.Workspace = require('./router');

$(function() {
    new TeamReport.Workspace();
    Backbone.history.start({ pushState: false });

    // Burger menu
    var burger = $('#menu-switch');
    var menu = $('#menu');
    burger.on('click', function (event) {
        event.preventDefault();
        burger.toggleClass('active');
    });
    burger.popover({
        html: true,
        placement: 'bottom',
        title: menu.data('title'),
        content: menu.html()
    });
});
