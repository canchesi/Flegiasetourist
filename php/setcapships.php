<?php
    require_once("config.php");

    /** @var MYSQLI $connection*/

    $date = date("Y-m-d H:i", strtotime(str_replace('/','-',$_GET['date'])));   //Data odierna formattata
    $capship = array(array(),array());  //Array di array per capitani e navi

    // Query che seleziona informazioni circa i capitani disponibili
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
    // Query che selezioni informazioni circa le navi disponibili
    $sql = "
            
        SELECT ships.id as sid, name, ret
            FROM ships LEFT JOIN routes
                ON ships.id = ship_id
            WHERE captain IS NULL AND NOT ships.unused 
    
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
                $capship[1][$row['sid']] = $row['name'];

    // Query che prende le informazioni circa navi e capitani che non sono ancora partiti
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
