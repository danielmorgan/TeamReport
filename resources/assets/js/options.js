'use strict';
var $ = require('jquery');

var options = {
    chart: {
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
    }
}

module.exports = options;