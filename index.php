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

        <script type="text/javascript" src="js/index.js"></script>
        <link rel="stylesheet" type="text/css" href="css/index.css">


        <title>VazquezElectronics</title>
    </head>
    <body>


        <div data-role="page">
            <div data-role="header">  
                <h1>Principal Cooler</h1>
            </div>

            <div data-role="content">   

                <table style="width: 50%; margin: 0 auto;">
                    <tr>
                        <th align="center" width="50%">Temperatura</th>
                        <th align="center" width="50%">Fecha</th>
                    </tr>

                    <?php
                    
                        $con=mysqli_connect("localhost","root","evc","Temperaturas");
                        // Check connection
                        if(mysqli_connect_errno()){
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }

                        $sql="SELECT * FROM temps ORDER BY created_at DESC";

                        if ($result=mysqli_query($con,$sql)){
                             // Fetch one and one row
                            while ($row=mysqli_fetch_row($result)){
                                
                                echo "<tr>";
                                echo "    <td align='center'>".$row[1]."</td>";
                                echo "    <td align='center'>".$row[2]."</td>";
                                echo "</tr>";

                            }
                            // Free result set
                            mysqli_free_result($result);
                        }

                        mysqli_close($con);
                        
                    ?>


                </table>


            </div>

        </div>





    </body>
</html>


