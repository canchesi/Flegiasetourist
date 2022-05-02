<?php

    require_once("config.php");

    /**@var MYSQLI $connection*/

    // Query che seleziona tutti i porti di parenza e arrivo
    $sql = '
                                                
        SELECT harb_dep, harb_arr
            FROM trades
            
    ';
    $arr = array();

    if($result = $connection->query($sql)){
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            if($_GET['city'] == $row['harb_dep'])
                $arr[] = $row['harb_arr'];
            else if ($_GET['city'] == $row['harb_arr'])
                $arr[] = $row['harb_dep'];
    }

    echo json_encode($arr);
