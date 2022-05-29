
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Clock</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <script
    type="text/javascript"
    src="/js/lib/dummy.js"
    
  ></script>

    <link rel="stylesheet" type="text/css" href="/css/result-light.css">


  <style id="compiled-css" type="text/css">
      #container {
    height: 370px; 
}

.highcharts-figure, .highcharts-data-table table {
    min-width: 300px; 
    max-width: 500px;
    margin: 0em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 0px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

  </style>



  
</head>
<body style="margin:0px;margin-top: -13px;">
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure" style="margin-top:0px;">
    <div id="container"></div>
</figure>


    <script type="text/javascript">//<![CDATA[


/**
 * Get the current time
 */
function getNow() {
    var now = new Date();

    return {
        hours: now.getHours() + now.getMinutes() / 60,
        minutes: now.getMinutes() * 12 / 60 + now.getSeconds() * 12 / 3600,
        seconds: now.getSeconds() * 12 / 60
    };
}

/**
 * Pad numbers
 */
function pad(number, length) {
    // Create an array of the remaining length + 1 and join it with 0's
    return new Array((length || 2) + 1 - String(number).length).join(0) + number;
}

var now = getNow();

// Create the chart
Highcharts.chart('container', {

    chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false,
        height: '80%'
    },

    credits: {
        enabled: false
    },

    title: {
        text: ''
    },

    pane: {
        background: [{
            // default background
        }, {
            // reflex for supported browsers
            backgroundColor: Highcharts.svg ? {
                radialGradient: {
                    cx: 0.5,
                    cy: -0.4,
                    r: 1.9
                },
                stops: [
                    [0.5, 'rgba(255, 255, 255, 0.2)'],
                    [0.5, 'rgba(200, 200, 200, 0.2)']
                ]
            } : null
        }]
    },

    yAxis: {
        labels: {
            distance: -20
        },
        min: 0,
        max: 12,
        lineWidth: 0,
        showFirstLabel: false,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 5,
        minorTickPosition: 'inside',
        minorGridLineWidth: 0,
        minorTickColor: '#666',

        tickInterval: 1,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        title: {
            text: 'Powered by<br/>Neways IT',
            style: {
                color: '#BBB',
                fontWeight: 'normal',
                fontSize: '8px',
                lineHeight: '10px'
            },
            y: 10
        }
    },

    tooltip: {
        formatter: function () {
            return this.series.chart.tooltipText;
        }
    },

    series: [{
        data: [{
            id: 'hour',
            y: now.hours,
            dial: {
                radius: '60%',
                baseWidth: 4,
                baseLength: '95%',
                rearLength: 0
            }
        }, {
            id: 'minute',
            y: now.minutes,
            dial: {
                baseLength: '95%',
                rearLength: 0
            }
        }, {
            id: 'second',
            y: now.seconds,
            dial: {
                radius: '100%',
                baseWidth: 1,
                rearLength: '20%'
            }
        }],
        animation: false,
        dataLabels: {
            enabled: false
        }
    }]
},

// Move
function (chart) {
    setInterval(function () {

        now = getNow();

        if (chart.axes) { // not destroyed
            var hour = chart.get('hour'),
                minute = chart.get('minute'),
                second = chart.get('second'),
                // run animation unless we're wrapping around from 59 to 0
                animation = now.seconds === 0 ?
                    false : {
                        easing: 'easeOutBounce'
                    };

            // Cache the tooltip text
            chart.tooltipText =
                    pad(Math.floor(now.hours), 2) + ':' +
                    pad(Math.floor(now.minutes * 5), 2) + ':' +
                    pad(now.seconds * 5, 2);


            hour.update(now.hours, true, animation);
            minute.update(now.minutes, true, animation);
            second.update(now.seconds, true, animation);
        }

    }, 1000);

});



  //]]></script>




</body>
</html>
