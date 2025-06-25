$(function() {
    $('.deleteImage').click(function(e) {
        e.preventDefault();
        var url = e.currentTarget.getAttribute('href');
        Swal.fire({
            title: "Esti sigur?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Da",
            cancelButtonText: "Nu"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});

// -------------------------------------------------------

var options_imagini = {
    chart: {
        type: 'bar',
        stacked: true,
        height: 400,
        toolbar: { show: true }
    },
    title: {
        text: 'Reacții la imagini: Like-uri vs Dislike-uri',
        align: 'center',
        style: {
            fontSize: '20px'
        }
    },
    plotOptions: {
        bar: {
            horizontal: false
        }
    },
    xaxis: {
        categories: [],
        labels: {
            rotate: -45,
            style: { colors: '#ccc' }
        }
    },
    yaxis: {
        title: { text: 'Număr reacții', style: { color: '#ccc' } }
    },
    legend: {
        position: 'top',
        labels: { colors: '#ccc' }
    },
    fill: {
        opacity: 1
    },
    series: [
        { name: 'Like-uri', data: [] },
        { name: 'Dislike-uri', data: [] }
    ]
};

var chart_imagini = new ApexCharts(document.querySelector("#chart_imagini"), options_imagini);
chart_imagini.render();

$.getJSON('../../api/imagini_chart.php', function(response) {
    chart_imagini.updateOptions({
        xaxis: { categories: response['titluri'] }
    });
    chart_imagini.updateSeries([
        { name: 'Like-uri', data: response['likes'] },
        { name: 'Dislike-uri', data: response['dislikes'] }
    ]);
});

