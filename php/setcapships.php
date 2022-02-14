<?php

    require_once("config.php");

    $city = $connection->real_escape_string($_GET["city"]);
    $date = $connection->real_escape_string($_GET["date"]);
    $capship = array(array(),array(),array());

    $sql = "
        
        SELECT id_code, name, surname, ret
            FROM users LEFT JOIN routes
                ON id_code = captain
            WHERE type ='capitano' AND ship_id IS NULL AND NOT users.deleted
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                if(strpos($row['surname'], "'"))
                    $row['surname'] = str_replace("'", "\'", $row['surname']);
                $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];
        }
    $sql = "
            
        SELECT id, name, harb1, harb2, ret
            FROM ships LEFT JOIN routes
                ON id = ship_id
            WHERE captain IS NULL AND NOT ships.unused AND (harb1 = '$city' OR harb2 = '$city' OR harb1 IS NULL)
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            if(!$row['harb1'])
                $capship[2][$row['id']] = $row['name'] . ' - Riserva';
            else
                $capship[1][$row['id']] = $row['name'];

    $sql = "
            
            SELECT MAX(arr_exp) AS arr_exp
                FROM users JOIN routes
                    ON captain = id_code
                WHERE NOT routes.deleted AND NOT users.deleted
                GROUP BY captain
    
        ";



    if($result = $connection->query($sql)){
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {

            $sql2 = "
            
                SELECT id_code, surname, users.name, arr_exp, trade_dep, trade_arr, ship_id, ships.name AS ship, ret
                    FROM users JOIN routes
                        ON id_code = captain
                    JOIN ships
                        ON ship_id = id
                    WHERE arr_exp = '" . $row['arr_exp'] . "'
            
            ";

            if($result2 = $connection->query($sql2))
                while($row = $result2->fetch_array(MYSQLI_ASSOC)) {
                    if($row['ret']){
                        $tmp = $row['trade_dep'];
                        $row['trade_dep'] = $row['trade_arr'];
                        $row['trade_arr'] = $tmp;
                        unset($tmp);
                    }
                    if ($row['trade_arr'] == $city && strtotime($date) > strtotime($row['arr_exp'])) {
                        if(strpos($row['surname'], "'"))
                            $row['surname'] = str_replace("'", "\'", $row['surname']);
                        $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];
                        $capship[1][$row['ship_id']] = $row['ship'];
                    }
                }
        }



        echo json_encode($capship);
    } else {
        echo "Error";
    }

    $connection->close();
