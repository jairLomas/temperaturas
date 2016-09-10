<?php  

    
    //$con=mysqli_connect("localhost:8889","test","huo0lpaw","Temperaturas");
    $con=mysqli_connect("localhost","root","evc","Temperaturas");
    // Check connection
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql='SELECT * FROM temps ORDER BY id DESC LIMIT 1';

    $json["message"] = "";
    $json["error"] = false;

    if ($result=mysqli_query($con,$sql)){

        $row=mysqli_fetch_row($result);

        $json["message"] = "Warning: The Freezer is ".$row[1]."F at ".date("d-F-Y H:i", strtotime($row[2]));
        $json["error"] = false;

        mysqli_free_result($result);
    }else{
        $json["error"] = true;
    }




 
    if( !$json["error"] ){

        echo "Envia SMS<br>";
        echo $json["message"];

        $key = "72fb3ca6-e344-4cf3-90c8-95b6a204e411";    
        $secret = "yRuhJHk4P0Gj0cAY1JnN+g==";
        $phone_number = "+5218113227435";

        $user = "application\\" . $key . ":" . $secret;    
        $message = array("message"=>$json["message"]);    
        $data = json_encode($message);    
        $ch = curl_init('https://messagingapi.sinch.com/v1/sms/' . $phone_number);    
        curl_setopt($ch, CURLOPT_POST, true);    
        curl_setopt($ch, CURLOPT_USERPWD,$user);    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    
        $result = curl_exec($ch);    
        if(curl_errno($ch)) {    
            echo 'Curl error: ' . curl_error($ch);    
        } else {    
            echo $result;    
        }   
        curl_close($ch);   

    }




?> 