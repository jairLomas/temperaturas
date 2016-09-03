<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

        <link rel="stylesheet" href="js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.css">
        <script src="js/jquery.mobile-1.4.5/jquery.min.js"></script>
        <script src="js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script src="js/canvasjs/jquery.canvasjs.min.js"></script>

        <link rel="stylesheet" type="text/css" href="css/index.css">


        <title>VazquezElectronics</title>
    </head>
    <body>




        <div data-role="page" id="principal_cooler_now">

            <div data-role="panel" id="mypanel" >
                <ul data-role="listview">
                    <li><a onclick='' data-rel="close">Principal Cooler Now</a></li>
                    <li><a href='history.php' attribute rel="external" data-ajax="false">Principal Cooler History</a></li>
                </ul>
            </div>

            <div data-role="header">  
                <a href="#mypanel" data-icon="bars">Menu</a>
                <h1>Principal Cooler Now</h1>
            </div>

            <div data-role="content">   
                <div id="chartContainer" ></div>
            </div>

        </div>

 


    </body>
</html>



<script>

$(document).ready(function(){



 
    var dps = []; // dataPoints
    var chart = new CanvasJS.Chart("chartContainer",{
        zoomEnabled: true, 
        animationEnabled: true,
        animationDuration: 1000,
        title :{
            text: "Principal Cooler"
        },   
        axisY:{ 
            title: "Temperature",
            includeZero: true,
        },   
        axisX:{ 
            title: "Time",
            includeZero: true
        },    
        data: [{
            type: "line",
            dataPoints: dps 
        }]
    });

    var xVal = 0;
    var yVal = 20; 
    var updateInterval = 15000;
    var dataLength = 30;
    var updateChart = function (count) {
      
        var data = {};
        data.dataLength = count;
        $.ajax({
            url: "API/getTemperatureGraph.php",
            type: "POST",
            data: data,
            dataType: "JSON",
            error: function(e){
                console.log(e);
            },
            success: function(result){

                for(var i = 0; i < result.data.length; i++){

                    var color = "";
                    if(parseFloat(result.data[i].temperatura) >= 10){
                        dps.push({
                            x: xVal,
                            y: parseFloat(result.data[i].temperatura),
                            label: result.data[i].fecha,
                            color: "#FF0000"
                        });
                    }else{
                        dps.push({
                            x: xVal,
                            y: parseFloat(result.data[i].temperatura),
                            label: result.data[i].fecha,
                            color: "#2E2E2E"
                        });
                    }


                    xVal++;
                }
                console.log(dps);
                if (dps.length > dataLength){
                    dps.shift();                
                }
                
                chart.render(); 

            }
        }); 

    };

    updateChart(dataLength); 
    setInterval(function(){updateChart()}, updateInterval); 

   

});

</script>
