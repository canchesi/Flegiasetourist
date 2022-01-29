<?php

    $row = array();
    foreach ($_GET['cities'] as $city)
        if ($city != $_GET['city'])
            $row[] = $city;

    echo json_encode($row);
