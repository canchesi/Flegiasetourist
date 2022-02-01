<?php

    require_once("config.php");

    $city = $connection->real_escape_string($_GET["city"]);
    $date = $connection->real_escape_string($_GET["date"]);

    $sql = "
        
        SELECT id_code, name, surname, arr_exp, trade_arr
            FROM users JOIN routes 
                ON captain = id_code
            WHERE arr_exp = (
                SELECT MAX(arr_exp)
                FROM users JOIN routes
                ON captain = id_code
            ) 
        
    ";


    $captains = array();

    if($result = $connection->query($sql)){
        while($row =  $result->fetch_array(MYSQLI_ASSOC))
            if(strtotime($date) > strtotime($row['arr_exp']) && $city == $row['trade_arr'])
                $captains[$row['id_code']] = $row['surname']." ".$row['name'];
        echo json_encode($captains);
    } else {
        echo "Error";
    }

    $connection->close();
