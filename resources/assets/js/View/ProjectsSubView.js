'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');

TeamReport.ProjectsSubView = Backbone.View.extend({
    tagName: 'li',
    className: 'project',
    template: _.template('<a href="/projects/<%= name %>"><%= id %> - <%= name %> - <%= company %></a>'),

    initialize: function() {
        this.model.on('change', this.render, this);
        this.render();
    },

    render: function() {
        this.$el.html(this.template(this.model.attributes));

        return this;
    }
});

module.exports = TeamReport.ProjectsSubView;
