<?php

    $row = array();
    foreach (json_decode($_GET['cities']) as $cities)
        foreach ($cities as $dep => $arr)
            if ($dep == $_GET['city'])
                $row[] = $arr;

    echo json_encode($row);
