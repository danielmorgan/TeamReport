'use strict';

var Chart = require('chart.js');
var report = require('../../../storage/app/report.json');

(function() {
    // Chart.defaults.global.customTooltips = function(tooltip) {
    //     if (! tooltip) {
    //         return;
    //     }

    //     console.log(tooltip);
    // };

    var options = {
        animation: false,
        responsive: true,
        scaleLabel: '<%=value%> hrs',
        scaleShowLine: true,
        scaleShowLineOut: false,
        scaleShowLabels: true,
        angleLineColor: 'rgba(0,0,0,0.05)',
        pointLabelFontSize: 10,
        pointLabelFontColor: 'rgba(231,76,60,1)',
        pointDotRadius: 4,
        datasetStroke: true,
    };

    report = Object.keys(report).map(function(key) { return report[key] });
    var charts = [];
    var i = 0;

    report.forEach(function(project) {
        var data = {
            labels: [],
            datasets: [
                {
                    label: 'Budgeted time',
                    fillColor: 'rgba(170,170,170,0.2)',
                    strokeColor: 'rgba(170,170,170,1)',
                    pointColor: 'rgba(170,170,170,1)',
                    pointStrokeColor: '#fff',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(170,170,170,1)',
                    data: []
                },
                {
                    label: 'Used time',
                    fillColor: 'rgba(231,76,60,0.3)',
                    strokeColor: 'rgba(231,76,60,1)',
                    pointColor: 'rgba(231,76,60,1)',
                    pointStrokeColor: '#fff',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(231,76,60,1)',
                    data: []
                }
            ]
        };

        project.tasklists = Object.keys(project.tasklists).map(function(key) { return project.tasklists[key] });
        project.tasklists.forEach(function(tasklist) {
            data.labels.push(tasklist.name);
            data.datasets[0].data.push(tasklist.budget);
            data.datasets[1].data.push(tasklist.used);
        });

        var canvas = document.createElement('canvas');
        var name = document.createTextNode(project.company + ' - ' + project.name);
        document.getElementById('charts').appendChild(canvas);
        var parentDiv = canvas.parentNode;
        parentDiv.insertBefore(name, canvas);

        charts.push(new Chart(document.getElementsByTagName('canvas')[i++].getContext('2d')).Radar(data, options));
    });

})();
