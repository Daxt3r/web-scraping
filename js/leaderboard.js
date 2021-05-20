$(function() {
    $("#datepickerVon").datepicker({
        inline: true,
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
    });
});
 
$(function() {
    $("#datepickerBis").datepicker({
        inline: true,
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
    });
});

$(function () {
    
    $('form').on('submit', function (e){
        
        e.preventDefault();
       
        $.ajax({
            data: $('form').serialize(),
            type: 'POST',
            url: 'functionController.php',
            success: function(response) {     
                
                console.log(response);
                var jsonData = JSON.parse(response);
                var titel = [];
                var summiert = [];
                            
                for(var i in jsonData) {
                    titel.push(jsonData[i].Titel);
                    summiert.push(jsonData[i].Anzahl);
                }

                drawChart('Summe der abgespielten Songs seit Aufzeichnung', titel, summiert);
            }
        });
    });
})

function drawChart(chartLabel, label_xAchse, data) {
    
    $("canvas#myChart").remove();
    $("div.content").append('<canvas id="myChart" class="animated fadeIn" "></canvas>');
    
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label_xAchse,
            datasets: [{
                label: chartLabel,
                data: data,
                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(105, 102, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 216, 86, 0.2)',
                                    'rgba(75, 152, 192, 0.2)',
                                    'rgba(153, 102, 215, 0.2)',
                                    'rgba(225, 159, 64, 0.2)'
                                ],
                borderColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(105, 102, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 216, 86, 0.2)',
                                'rgba(75, 152, 192, 0.2)',
                                'rgba(153, 102, 215, 0.2)',
                                'rgba(225, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                }]
        },
        options: {
                    scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
        }
    });
}