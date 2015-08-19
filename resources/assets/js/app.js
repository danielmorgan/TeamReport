'use strict';

var Chart = require('chart.js');

(function() {
    Chart.defaults.global.customTooltips = function(tooltip) {
        if (! tooltip) {
            return;
        }

        console.log(tooltip);
    };

    var data = {
        labels: ['Project Management', 'Research', 'Design', 'Frontend Development', 'Systems Development', 'Testing'],
        datasets: [
            {
                label: 'Budgeted time',
                fillColor: 'rgba(220,220,220,0.2)',
                strokeColor: 'rgba(220,220,220,1)',
                pointColor: 'rgba(220,220,220,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [45, 60, 60, 50, 50, 60]
            },
            {
                label: 'Used time',
                fillColor: 'rgba(231,76,60,0.3)',
                strokeColor: 'rgba(231,76,60,1)',
                pointColor: 'rgba(231,76,60,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(231,76,60,1)',
                data: [20, 20, 20, 20, 20, 20]
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
        pointLabelFontSize: 0,
        pointLabelFontColor: 'rgba(231,76,60,1)',
        pointDotRadius: 4,
        datasetStroke: false,
    };

    var charts = {
        testChart: new Chart(document.getElementById('testChart').getContext('2d')).Radar(data, options),
    };

})();
