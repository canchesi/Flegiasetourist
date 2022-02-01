<?php

    require_once("config.php");

    $row = array();
    foreach (json_decode($_GET['cities']) as $cities)
        foreach ($cities as $dep => $arr)
            if ($dep == $_GET['city'])
                $row[] = $arr;

    $sql = "
    
        SELECT MAX(arr_exp) AS date
            FROM routes
            WHERE trade_arr = '" . $_GET['city'] . "'
    
    ";

    if($result = $connection->query($sql))
        $row['time'] = $result->fetch_array(MYSQLI_ASSOC);

    echo json_encode($row);
