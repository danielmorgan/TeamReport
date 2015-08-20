'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');

TeamReport.ProjectView = Backbone.View.extend({
    tagName: 'li',
    className: 'project',
    template: _.template('<%= id %> - <%= name %> - <%= company %>'),

    initialize: function() {
        this.model.on('change', this.render, this);
        this.model.fetch();
    },

    render: function() {
        this.$el.html(this.template(this.model.attributes));
        $('#container').html(this.$el);

        return this;
    }
});

module.exports = TeamReport.ProjectView;
