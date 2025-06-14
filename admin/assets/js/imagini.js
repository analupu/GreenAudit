$(function() {
    $('.deleteImage').click(function(e) {
        e.preventDefault();
        var url = e.currentTarget.getAttribute('href');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
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
        background: '#2b3035',
        toolbar: { show: true }
    },
    theme: { mode: 'dark' },
    title: {
        text: 'Reacții la imagini: Like-uri vs Dislike-uri',
        align: 'center',
        style: {
            color: '#fff',
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

