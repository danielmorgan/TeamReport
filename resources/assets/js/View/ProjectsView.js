'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');
TeamReport.ProjectView = require('./ProjectView.js');

TeamReport.ProjectsView = Backbone.View.extend({
    tagName: 'ul',
    className: 'projects',

    initialize: function() {
        console.log(this.collection);
        var self = this;

        this.collection.on('update', this.test, this);
        this.collection.fetch();

        this.render();
    },

    test: function() {
        console.log(this.collection.models);
    },

    render: function() {
        // _.each(this.subViews, function(view) {
        //     this.$el.append(view.el);
        // }, this);
    }
});

module.exports = TeamReport.ProjectsView;
