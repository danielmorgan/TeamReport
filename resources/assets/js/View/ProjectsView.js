'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');
TeamReport.ProjectsSummaryView = require('./ProjectsSummaryView');

TeamReport.ProjectsView = Backbone.View.extend({
    selector: '#template-projects',

    initialize: function() {
        this.template = _.template($(this.selector).html());
        this.className = $(this.selector).attr('class');
        this.tagName = $(this.selector).attr('data-tag');

        this.collection.on('update', this.render, this);
        this.collection.fetch();
        this.render();
    },

    buildSubViews: function() {
        var self = this;
        this.$el.html(this.template());

        _.forEach(this.collection.models, function(model) {
            var projectView = new TeamReport.ProjectsSummaryView({ model: model });
            self.$el.append(projectView.$el);
        });
    },

    render: function() {
        this.$el.addClass(this.className);
        this.buildSubViews();
        $('#team-report').html(this.$el);

        return this;
    }
});

module.exports = TeamReport.ProjectsView;
