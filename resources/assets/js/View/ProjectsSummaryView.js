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

    buildProjectEl: function() {
        this.model.set({
            used: this.sumAttributes('used'),
            budget: this.sumAttributes('budget')
        });

        this.$el.html(this.template(this.model.attributes));

        this.$el.addClass(this.className);
        this.$el.addClass('hvr-float');

        if (this.model.get('used') > this.model.get('budget')) {
            this.$el.addClass('over-budget');
        };
    },

    sumAttributes: function(attr) {
        var total = 0;
        _.forEach(this.model.get('tasklists'), function(tasklist) {
            total += tasklist[attr];
        });
        return total;
    },

    render: function() {
        this.buildProjectEl();

        return this;
    }
});

module.exports = TeamReport.ProjectSummaryView;
