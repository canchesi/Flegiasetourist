<?php
    require_once("config.php");

    //$date = str_replace('/','-',$_GET['date']);
    $date = date("Y-m-d H:i", strtotime(str_replace('/','-',$_GET['date'])));
    $capship = array(array(),array());
    $sql = "
        
        SELECT id_code, name, surname, ret
            FROM users LEFT JOIN routes
                ON id_code = captain
            WHERE type ='capitano' AND ship_id IS NULL AND NOT users.deleted
    
    ";
    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];
        }

    $sql = "
            
        SELECT ships.id as sid, name, ret
            FROM ships LEFT JOIN routes
                ON ships.id = ship_id
            WHERE captain IS NULL AND NOT ships.unused 
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
                $capship[1][$row['sid']] = $row['name'];

    $sql = "
            
        SELECT id_code, surname, users.name AS name, ship_id, ships.name AS ship
            FROM users
                JOIN routes
                    ON id_code = captain
                JOIN ships
                    ON ship_id = ships.id
            WHERE NOT routes.deleted AND NOT users.deleted AND arr_exp < '" . $date . "'
    ";
    if($result = $connection->query($sql)){
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $capship[0][$row['id_code']] = $row['surname'] . " " . $row['name'];
            $capship[1][$row['ship_id']] = $row['ship'];
        }
        echo json_encode($capship);
    } else {
        echo "Error";
    }

    $connection->close();
