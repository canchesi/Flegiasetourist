<?php

    require_once('config.php');
    /** @var MYSQLI $connection*/
    session_start();

    // Query che seleziona la rotta più vicina del capitano in question
    $sql = "
        SELECT routes.id
            FROM users JOIN routes
                ON captain = id_code
            WHERE id_code = '" . $_SESSION['id'] . "' AND dep_exp = ANY(
                SELECT MIN(dep_exp) AS dep
                    FROM users JOIN routes
                        ON captain = id_code
                    WHERE id_code = '" . $_SESSION['id'] . "' AND dep_exp >= '" . $_GET['today'] . "' AND dep_exp < '" . $_GET['tomorrow'] . "' AND NOT routes.deleted ";

    if(!$_GET['start']) {
        $sql .= "AND dep_eff IS NULL";
        $_GET['start'] = true;
    } else {
        $sql .= "AND dep_eff IS NOT NULL AND arr_eff IS NULL";
        $_GET['start'] = false;
    }
    $sql .= ")";

    if($result = $connection->query($sql)){
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            if ($_GET['start'])
                // Query che aggiorna la data di partenza effettiva
                $sql = "
            
                    UPDATE routes
                        SET dep_eff = '" . date('Y-m-d H:i') . "'
                    WHERE id = '" . $row['id'] . "';
                
                ";
            else
                // Query che aggiorna la data di arrivo effettiva e le note di viaggio
                $sql = "
            
                UPDATE routes
                    SET
                        arr_eff = '" . date('Y-m-d H:i') . "',
                        notes = '" . $_GET['note'] . "'
                WHERE id = '" . $row['id'] . "';
            
            ";
            if($connection->query($sql))
                echo  1;
            else
                echo 0;

        }
    } else
        echo 0;

