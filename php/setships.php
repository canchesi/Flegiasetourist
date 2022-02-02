<?php

    require_once("config.php");

    $city = $connection->real_escape_string($_GET["city"]);
    $date = $connection->real_escape_string($_GET["date"]);

    $sql = "
        
        SELECT id, name, MAX(arr_exp) AS arr_exp, trade_arr
            FROM ships JOIN routes 
                ON ship_id = id
            WHERE trade_arr = '$city'
            GROUP BY ship_id
        
    ";


    $captains = array();


    if($result = $connection->query($sql)){
        while($row =  $result->fetch_array(MYSQLI_ASSOC))
            if(strtotime($date) > strtotime($row['arr_exp']))
                $captains[$row['id']] = $row['name'];
        echo json_encode($captains);
    } else {
        echo "Error";
    }

    $connection->close();
