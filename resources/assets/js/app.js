'use strict';

var Chart = require('chart.js');
var reports = require('../../../storage/app/report-latest.json');

(function() {
    Chart.defaults.global.customTooltips = function(tooltip) {
        if (! tooltip) {
            return;
        }

        console.log(tooltip);
    };

    var data = {
        labels: [],
        datasets: [
            {
                label: 'Budgetedtime',
                fillColor: 'rgba(231,76,60,0.3)',
                strokeColor: 'rgba(231,76,60,1)',
                pointColor: 'rgba(231,76,60,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(231,76,60,1)',
                data: []
            },
            {
                label: 'Used time',
                fillColor: 'rgba(220,220,220,0.2)',
                strokeColor: 'rgba(220,220,220,1)',
                pointColor: 'rgba(220,220,220,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: []
            }
        ]
    };

    var options = {
        animation: false,
        responsive: true,
        scaleLabel: '<%=value%> hrs',
        scaleShowLine: true,
        scaleShowLineOut: false,
        scaleShowLabels: true,
        angleLineColor: 'rgba(0,0,0,0.05)',
        pointLabelFontSize: 16,
        pointLabelFontColor: 'rgba(231,76,60,1)',
        pointDotRadius: 4,
        datasetStroke: false,
    };

    reports = Object.keys(reports).map(function(key) { return reports[key] });
    reports.forEach(function(report) {
        report.forEach(function(tasklist) {
            data.labels.push(tasklist.tasklist);
            data.datasets[0].data.push(tasklist.budget);
        });
    });

    var charts = {
        testChart: new Chart(document.getElementById('testChart').getContext('2d')).Radar(data, options),
    };

})();
