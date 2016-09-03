<?php
    $json["data"] = "";

    //$con=mysqli_connect("localhost:8889","test","huo0lpaw","Temperaturas");
    $con=mysqli_connect("localhost","root","evc","Temperaturas");
    // Check connection
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql='SELECT * FROM temps WHERE DATE_FORMAT(created_at, "%d-%m-%Y") >= "'.$_POST["dateStart"].'" AND DATE_FORMAT(created_at, "%d-%m-%Y") <= "'.$_POST["dateEnd"].'" ORDER BY id DESC';

    $data = array();
    if ($result=mysqli_query($con,$sql)){

        while ($row=mysqli_fetch_row($result)){
            $aux = array();
            $aux["id"]          = $row[0];
            $aux["temperatura"] = $row[1];
            $aux["fecha"]       = date("H:i", strtotime($row[2]));
            $data[] = $aux;
        }
        $json["data"] = array_reverse($data);
        mysqli_free_result($result);
    }

    mysqli_close($con);
    
    echo json_encode($json);
?>
