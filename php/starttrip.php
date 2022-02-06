<?php

    require_once('config.php');

    session_start();

    $sql = "
    
        SELECT MIN(dep_exp) AS dep
            FROM users JOIN routes
                ON captain = id_code
            WHERE id_code = '" . $_SESSION['id'] . "' AND dep_exp >= '" . $_GET['today'] . "' AND dep_exp < '" . $_GET['tomorrow'] . "' 
            
    ";

    if(!$_GET['start']) {
        $sql .= "AND dep_eff IS NULL";
        $_GET['start'] = true;
    } else {
        $sql .= "AND dep_eff IS NOT NULL AND arr_eff IS NULL";
        $_GET['start'] = false;
    }

    if($result = $connection->query($sql)){
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $sql = "
                SELECT ship_id, dep_exp
                    FROM users JOIN routes
                       ON captain = id_code
                    WHERE id_code = '" . $_SESSION['id'] . "' AND dep_exp = '" . $row['dep'] . "' 
            ";

            if ($result = $connection->query($sql)) {
                if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    if ($_GET['start'])
                        $sql = "
                    
                            UPDATE routes
                                SET dep_eff = '" . date('Y-m-d H:i') . "'
                            WHERE ship_id = '" . $row['ship_id'] . "' AND dep_exp = '" . $row['dep_exp'] . "';
                        
                        ";
                    else
                        $sql = "
                    
                        UPDATE routes
                            SET arr_eff = '" . date('Y-m-d H:i') . "'
                        WHERE ship_id = '" . $row['ship_id'] . "' AND dep_exp = '" . $row['dep_exp'] . "';
                    
                    ";

                    if(($result = $connection->query($sql)) && $_GET['note'] !== ""){

                        $sql = "INSERT INTO notes VALUES('" . $row['ship_id'] . "', '" . $row['dep_exp'] . "', '" . $_GET['note'] . "')";
                        $connection->query($sql);

                    }
                    echo  1;

                }
            }
        }
    } else
        echo 0;

