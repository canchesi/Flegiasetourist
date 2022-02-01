<?php

    require_once('config.php');

    $captains = array();
    $sql = "
                            
        SELECT id_code, name, surname 
            FROM users JOIN routes 
                ON id_code != captain
            WHERE type = 'capitano'
        
    ";

    if ($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $captains[$row['id_code']] = $row['surname'] . " " . $row['name'];

    echo json_encode($captains);
