'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');

TeamReport.ProjectView = Backbone.View.extend({
    tagName: 'div',
    className: 'project',

    initialize: function() {
        this.template = _.template($('#template-project').html());
        var self = this;

        this.model.on('change', this.render, this);
        this.model.fetch({
            success: function(model) {
                self.$el.html(self.template(model.attributes));
            },
            error: function(model, response) {
                self.$el.html('<h3>Error ' + response.status + '</h3><p>' + response.responseJSON.message + '</p>');
                model.trigger('change');
            }
        });
    },

    render: function() {
        $('#team-report').html(this.$el);

        return this;
    }
});

module.exports = TeamReport.ProjectView;
