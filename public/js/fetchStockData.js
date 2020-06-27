var ctx = document.getElementById('dataChart').getContext('2d');
var dataChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Stock Price',
            data: apiData,
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        legend:{
            display:false
        },

        scales: {
            xAxes: [{
                display: false
                
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: false,
                },
            }]
        }
    }
});

function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

var apiData = [];

function fetchdata(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: window.location.href,
        type: 'post',
        success: function(stockData){
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes();
            stockData = JSON.parse(stockData);
            addData(dataChart, time, stockData['latestPrice']);
        },
        complete:function(stockData){
            setTimeout(fetchdata,900000);
        }
    });
}
   
$(document).ready(function(){
    fetchdata();
});

