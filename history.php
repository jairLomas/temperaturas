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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

        <link rel="stylesheet" type="text/css" href="css/index.css">


        <title>Freezer Los Primos</title>
    </head>
    <body>




        <div data-role="page" id="principal_cooler_history">

            <div data-role="panel" id="mypanel" >
                <ul data-role="listview">
                    <li><a href='index.php' data-role="none" attribute rel="external" data-ajax="false">Freezer Los Primos Now</a></li>
                    <li><a onclick='' data-rel="close">Freezer Los Primos History</a></li>
                </ul>
            </div>

            <div data-role="header">  
                <a href="#mypanel" data-icon="bars">Menu</a>
                <h1>Freezer Los Primos History</h1>
            </div>

            <div data-role="content">   
                <div id="history_dates">


                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            Date Start
                        </div>
                        <div class="ui-block-b">
                            Date End
                        </div>
                   </div>                    
                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <input type="text" value="" id="date_start" />
                        </div>
                        <div class="ui-block-b">
                            <input type="text" value="" id="date_end" />
                        </div>
                   </div>
                </div>
                <div id="chartContainerHistory" ></div>
            </div>

        </div>




    </body>
</html>



<script>

var xVal = 0;
var yVal = 20; 
var updateInterval = 60 * 1000;
var dataLength = 30;

$(document).ready(function(){



    $("#date_start").datepicker({ dateFormat: 'dd-mm-yy' }).datepicker("setDate",new Date());;
    $("#date_end").datepicker({ dateFormat: 'dd-mm-yy' }).datepicker("setDate",new Date());;


    var updateChart = function (date_start, date_end) {
      
        var data = {};
        data.dateStart = date_start;
        data.dateEnd = date_end;
        $.ajax({
            url: "API/getTemperatureGraphHistory.php",
            type: "POST",
            data: data,
            dataType: "JSON",
            error: function(e){
                console.log(e);
            },
            success: function(result){

                console.log(result);
                var dps = []; // dataPoints
                for(var i = 0; i < result.data.length; i++){

                    var color = "";
                    if(parseFloat(result.data[i].temperatura) >= 0){
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

                var chart = new CanvasJS.Chart("chartContainerHistory",{
                    zoomEnabled: true, 
                    animationEnabled: true,
                    animationDuration: 1000,
                    title :{
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

                chart.render(); 

            }
        }); 

    };

    updateChart($("#date_start").val(), $("#date_end").val()); 
   


    $("#date_start, #date_end").on("change", function(){
        updateChart($("#date_start").val(), $("#date_end").val()); 
    });

});




</script>
