var options_history = {
    chart: {
        type: 'polarArea',
        height: 500,
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

// var url = 'http://localhost/api/tipuri_locuinte.php';

$.getJSON('/api/tipuri_locuinte.php', function(response) {
    chart_history.updateOptions({labels: response['numeLocuinte']});
    chart_history.updateSeries(response['numarLocuinte']);
});


// --------------------------------------

var options_categorii = {
    chart: {
        type: 'donut',
        height: 500,
        background: '#2b3035',
        toolbar: { show: true }
    },
    theme: {
        mode: 'dark',
        palette: 'palette2'
    },
    noData: {
        text: 'Se încarcă...'
    },
    title: {
        text: 'Distribuția articolelor pe categorii',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#ffffff'
        }
    },
    legend: {
        position: 'bottom'
    }
};

var chart_categorii = new ApexCharts(document.querySelector("#chart_categorii_articole"), options_categorii);
chart_categorii.render();

$.getJSON('/api/categorii_articole.php', function(response) {
    chart_categorii.updateOptions({ labels: response['categorii'] });
    chart_categorii.updateSeries(response['valori']);
});

// -------------------------------------------------------

var options_simulari = {
    chart: {
        type: 'bar',
        height: 500,
        background: '#2b3035',
        toolbar: { show: true }
    },
    theme: { mode: 'dark' },
    title: {
        text: 'Simulări pe săptămâni',
        align: 'center',
        style: {
            color: '#fff',
            fontSize: '20px'
        }
    },
    xaxis: {
        categories: [],
        labels: { rotate: -45 }
    },
    series: [{
        name: 'Simulări',
        data: []
    }],
    noData: {
        text: 'Se încarcă...'
    }
};

var chart_simulari = new ApexCharts(document.querySelector("#chart_simulari"), options_simulari);
chart_simulari.render();

$.getJSON('/api/simulari_pe_saptamana.php', function(response) {
    chart_simulari.updateOptions({ xaxis: { categories: response['saptamani'] } });
    chart_simulari.updateSeries([{ name: 'Simulări', data: response['valori'] }]);
});

