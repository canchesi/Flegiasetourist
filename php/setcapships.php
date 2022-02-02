<?php

    require_once("config.php");

    $city = $connection->real_escape_string($_GET["city"]);
    $date = $connection->real_escape_string($_GET["date"]);
    $capship = array(array(),array());

    $sql = "
        
        SELECT id_code, name, surname
            FROM users LEFT JOIN routes
                ON id_code = captain
            WHERE type ='capitano' AND ship_id IS NULL
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];

    $sql = "
            
        SELECT id, name
            FROM ships LEFT JOIN routes
                ON id = ship_id
            WHERE captain IS NULL
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $capship[1][$row['id']] = $row['name'];

    $sql = "
            
            SELECT MAX(arr_exp) AS arr_exp
                FROM users JOIN routes
                    ON captain = id_code
                GROUP BY captain
    
        ";



    if($result = $connection->query($sql)){
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {

            $sql2 = "
            
                SELECT id_code, surname, users.name, arr_exp, trade_arr, ship_id, ships.name AS ship
                    FROM users JOIN routes
                        ON id_code = captain
                    JOIN ships                    	
                        ON ship_id = id                
                    WHERE arr_exp = '" . $row['arr_exp'] . "'
            
            ";

            if($result2 = $connection->query($sql2))
                while($row = $result2->fetch_array(MYSQLI_ASSOC))
                    if($row['trade_arr'] == $city && strtotime($date) > strtotime($row['arr_exp'])) {
                        $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];
                        $capship[1][$row['ship_id']] = $row['ship'];
                    }
        }



        echo json_encode($capship);
    } else {
        echo "Error";
    }

    $connection->close();
