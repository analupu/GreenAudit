var options_history = {
    chart: {
        type: 'line',
    },
    series: [],
    noData: {
        text: 'Loading...'
    },
    grid: {
        show: false,
    },
    yaxis: [
        {
            labels: {
                formatter: function (value) {
                    return value.toFixed(2) + ' lei';
                }
            },
        },
        {
            labels: {
                formatter: function (value) {
                    return value.toFixed(2) + ' kW' ;
                }
            },
        },
        {
            labels: {
                formatter: function (value) {
                    return value + ' ore' ;
                }
            },
        }
    ],
    title: {
        text: 'Istoric',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
            fontSize:  '20px',
        },
    }
}

var chart_history = new ApexCharts($('#chart_history')[0], options_history);
chart_history.render();

var url = 'http://localhost/api/history_data.php';

$.getJSON(url, function(response) {
    var consulTotalLei = response[0];
    var consumTotalKw = response[1];
    var numarOreTotal = response[2];

    chart_history.updateSeries([{
        name: 'Consum total lei',
        data: consulTotalLei,
    }, {
        name: 'Consum total kW',
        data: consumTotalKw
    }, {
        name: 'Numar total ore',
        data: numarOreTotal
    }])
});

var options_settings_history = {
    chart: {
        type: 'line',
    },
    series: [],
    noData: {
        text: 'Loading...'
    },
    yaxis: [
        {
            labels: {
                formatter: function (value) {
                    return value.toFixed(2) + ' lei';
                }
            },
        },
        {
            labels: {
                formatter: function (value) {
                    return value + ' persoane' ;
                }
            },
        },
        {
            labels: {
                formatter: function (value) {
                    return value.toFixed(2) + ' lei' ;
                }
            },
        }
    ],
    title: {
        text: 'Istoric venit',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
            fontSize:  '20px',
        },
    },
    grid: {
        show: false,
    }
}

var chart_settings_history = new ApexCharts($('#chart_settings_history')[0], options_settings_history);
chart_settings_history.render();

var url = 'http://localhost/api/settings_history.php';

$.getJSON(url, function(response) {
    var venitTotal = response[0];
    var numarMembri = response[1];
    var venitPeMembru = response[2];

    chart_settings_history.updateSeries([{
        name: 'Venit total',
        data: venitTotal,
    }, {
        name: 'Numar membri',
        data: numarMembri
    }, {
        name: 'Venit / membru',
        data: venitPeMembru
    }])
});