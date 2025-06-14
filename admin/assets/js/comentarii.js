$(function() {
    $('.deleteComment').click(function(e) {
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

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("table tbody tr");

    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
});

var optionsTon = {
    chart: {
        type: 'bar',
        height: 600,
        background: '#2b3035',
        toolbar: { show: false }
    },
    theme: { mode: 'dark' },
    title: {
        text: 'Distribuția tonului comentariilor',
        align: 'center',
        style: { color: '#fff', fontSize: '18px' }
    },
    xaxis: {
        categories: [],
        labels: { style: { colors: '#ccc' } }
    },
    yaxis: {
        title: { text: 'Număr comentarii', style: { color: '#ccc' } },
        labels: { style: { colors: '#ccc' } }
    },
    colors: ['#198754', '#6c757d', '#dc3545'],
    series: [{
        name: 'Comentarii',
        data: []
    }],
    plotOptions: {
        bar: {
            columnWidth: '50%',
            distributed: true
        }
    },
    legend: { show: false }
};

var chartTon = new ApexCharts(document.querySelector("#chart_ton_comentarii"), optionsTon);
chartTon.render();

$.getJSON('/api/ton_comentarii.php', function(response) {
    chartTon.updateOptions({ xaxis: { categories: response.labels } });
    chartTon.updateSeries([{ data: response.series }]);
});

//  -----------------------------

var optionsHeatmap = {
    chart: {
        type: 'heatmap',
        height: 600,
        background: '#2b3035',
        toolbar: { show: false }
    },
    dataLabels: {
        enabled: true,
        style: {
            colors: ['#ffffff'],
            fontSize: '14px',
            fontWeight: 'bold'
        }
    },
    theme: { mode: 'dark' },
    colors: ['#28a745'],
    title: {
        text: 'Distribuția tonului pe ultimele comentarii',
        style: { color: '#fff' },
        align: 'center'
    },
    xaxis: {
        labels: { style: { colors: '#ccc' } }
    },
    yaxis: {
        labels: { style: { colors: '#ccc' } }
    },
    plotOptions: {
        heatmap: {
            shadeIntensity: 0.9,
            radius: 5,
            useFillColorAsStroke: true,
            colorScale: {
                ranges: [
                    {
                        from: 0,
                        to: 0,
                        color: "#ECE5F0",
                        name: "Zero"
                    },
                    {
                        from: 1,
                        to: 1,
                        color: "#B07BAC",
                        name: "Scăzut"
                    },
                    {
                        from: 2,
                        to: 3,
                        color: "#59114D",
                        name: "Mediu"
                    },
                    {
                        from: 4,
                        to: 10,
                        color: "#22162B",
                        name: "Intens"
                    }
                ]
            }
        }
    },
    series: []
};

var chartHeatmap = new ApexCharts(document.querySelector("#heatmap_ton_comentarii"), optionsHeatmap);
chartHeatmap.render();

$.getJSON("/api/heatmap_ton_comentarii.php", function(data) {
    chartHeatmap.updateSeries(data);
});

