<?php

    require_once("config.php");

    $city = $connection->real_escape_string($_GET["city"]);

    $sql = "
        
        SELECT id, name  
            FROM ships JOIN routes 
                ON ship_id = id
            WHERE trade_arr = '$city'
        
    ";


    $captains = array();


    if($result = $connection->query($sql)){
        while($row =  $result->fetch_array(MYSQLI_ASSOC))
            $captains[$row['id']] = $row['name'];
        echo json_encode($captains);
    } else {
        echo "Error";
    }

    $connection->close();
