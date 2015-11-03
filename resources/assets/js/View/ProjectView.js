'use strict';
var TeamReport = TeamReport || {};

var _ = require('lodash');
var $ = require('jquery');
var Backbone = require('backbone');
var Chart = require('chart.js');
var options = {
    animation: true,
    responsive: true,
    scaleLabel: '<%=value%> hrs',
    scaleShowLine: true,
    scaleShowLineOut: false,
    scaleShowLabels: true,
    angleLineColor: 'rgba(0,0,0,0.05)',
    pointLabelFontSize: 14,
    pointLabelFontFamily: 'Open Sans',
    pointDotRadius: 5,
    datasetStroke: true,
    scaleBeginAtZero: false,
    customTooltips: function(tooltip) {
        if (!tooltip) {
            $('.tasklists tr').removeClass('highlighted');
            return;
        }
        $('.tasklists tr').removeClass('highlighted');
        $('.tasklists .key:contains(' + tooltip.title + ')').parent('tr').addClass('highlighted');
    }
};

TeamReport.ProjectView = Backbone.View.extend({
    tagName: 'div',
    className: 'project',

    initialize: function() {
        this.template = _.template($('#template-project').html());
        var self = this;

        this.model.on('change', this.render, this);
        this.model.fetch({
            success: function(model) {
                self.buildProjectEl();
            },
            error: function(model, response) {
                self.$el.html('<h3>Error ' + response.status + '</h3><p>' + response.responseJSON.message + '</p>');
                model.trigger('change');
            }
        });
    },

    buildProjectEl: function() {
        this.model.set({
            used: this.sumAttributes('used'),
            budget: this.sumAttributes('budget')
        });

        this.$el.html(this.template(this.model.attributes));

        this.buildChart();
    },

    buildChart: function() {
        var chartCanvas = document.getElementById('chart');

        var tasklists = { name: [], budget: [], used: [] };
        var i = 0;
        _.forEach(this.model.get('tasklists'), function(tasklist) {
            if (tasklist.used > 0 || tasklist.budget > 0) {
                tasklists.name.push(tasklist.name);
                tasklists.used.push(tasklist.used);
                tasklists.budget.push(tasklist.budget);
                i++;
            }
        });

        new Chart(chartCanvas.getContext('2d'))
            .Radar({
                labels: tasklists.name,
                datasets: [
                    {
                        label: 'Budgeted time',
                        fillColor: 'rgba(170,170,170,0.2)',
                        strokeColor: 'rgba(170,170,170,1)',
                        pointColor: 'rgba(170,170,170,1)',
                        pointStrokeColor: '#fff',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(170,170,170,1)',
                        data: tasklists.budget
                    },
                    {
                        label: 'Used time',
                        fillColor: 'rgba(231,76,60,0.3)',
                        strokeColor: 'rgba(231,76,60,1)',
                        pointColor: 'rgba(231,76,60,1)',
                        pointStrokeColor: '#fff',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(231,76,60,1)',
                        data: tasklists.used
                    }
                ]
            }, options);
    },

    sumAttributes: function(attr) {
        var total = 0;
        _.forEach(this.model.get('tasklists'), function(tasklist) {
            total += tasklist[attr];
        });
        return total;
    },

    render: function() {
        $('#team-report').html(this.$el);

        return this;
    }
});

module.exports = TeamReport.ProjectView;
