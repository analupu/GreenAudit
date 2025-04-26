var options_history = {
    chart: {
        type: 'polarArea',
        background: '#2b3035',
        toolbar: {
            show: true
        },
    },
    theme: {
        mode: 'dark',
        palette: 'palette1'
    },
    noData: {
        text: 'Loading...'
    },
    title: {
        text: 'Tipuri locuinte',
        align: 'center',
        margin: 10,
        offsetX: 0,
        offsetY: 0,
        floating: false,
        style: {
            fontSize:  '24px',
            fontWeight:  'bold',
            color:  '#ffffff'
        },
    },
    yaxis: {
        show: false,
    },
    fill: {
        opacity: 1
    },
    legend: {
        position: 'bottom'
    }
}

var chart_history = new ApexCharts($('#chart_house_type')[0], options_history);
chart_history.render();

var url = 'http://localhost/api/tipuri_locuinte.php';

$.getJSON(url, function(response) {
    chart_history.updateOptions({labels: response['numeLocuinte']});
    chart_history.updateSeries(response['numarLocuinte']);
});