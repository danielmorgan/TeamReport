'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');
TeamReport.ProjectsSubView = require('./ProjectsSubView.js');

TeamReport.ProjectsView = Backbone.View.extend({
    tagName: 'ul',
    className: 'projects',

    initialize: function() {
        this.collection.on('update', this.render, this);
        this.collection.fetch();
        this.render();
    },

    buildSubViews: function() {
        var self = this;
        _.forEach(this.collection.models, function(model) {
            var projectView = new TeamReport.ProjectsSubView({ model: model });
            self.$el.append(projectView.$el);
        });
    },

    render: function() {
        this.buildSubViews();
        $('#container').html(this.$el);

        return this;
    }
});

module.exports = TeamReport.ProjectsView;
