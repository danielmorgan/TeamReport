'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');

TeamReport.ProjectSummaryView = Backbone.View.extend({
    selector: '#template-project-summary',

    initialize: function() {
        this.template = _.template($(this.selector).html());
        this.className = $(this.selector).attr('class');
        this.tagName = $(this.selector).attr('data-tag');
        
        this.model.on('change', this.render, this);
        this.render();
    },

    render: function() {
        this.$el.addClass(this.className);
        this.$el.html(this.template(this.model.attributes));

        return this;
    }
});

module.exports = TeamReport.ProjectSummaryView;
