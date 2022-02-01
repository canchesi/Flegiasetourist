<?php

    require_once('config.php');

    $ships = array();
    $sql = "
                            
        SELECT id, name 
            FROM ships JOIN routes 
                ON trade_arr = '" . $_GET['lastCity'] . "'
        
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $ships[$row['id']] = $row['name'];

    echo json_encode($ships);
