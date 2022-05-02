<?php

require_once("config.php");

/** @var MySQLI $connection */

$selectedCity = $connection->real_escape_string($_GET["city"]);

// Query che seleziona tutti gli altri porti disponibili
$sql = "SELECT city FROM harbors WHERE city != '$selectedCity'";

if ($result = $connection->query($sql)) {
    while ($cities = $result->fetch_array(MYSQLI_ASSOC)) {
        if ($cities['city'] != $_GET['city'])
            $row[] = $cities['city'];
    }

    // Query che seleziona porti già relazionati con quello di partenza selezionato
    $sql = "SELECT * FROM trades WHERE harb_dep = '$selectedCity' OR harb_arr = '$selectedCity'";

    if ($resultFilter = $connection->query($sql)) {
        while ($resRow = $resultFilter->fetch_array(MYSQLI_ASSOC)) {
            if (in_array($resRow['harb_dep'], $row) && $resRow['deleted'] != 1) {
                $pos = array_search($resRow['harb_dep'], $row);
                unset($row[$pos]);
            }
            if (in_array($resRow['harb_arr'], $row) && $resRow['deleted'] != 1) {
                $pos = array_search($resRow['harb_arr'], $row);
                unset($row[$pos]);
            }
        }
    } else {
        echo "Errore";
    }

} else {
    echo "Errore";
}

$row = array_values($row);

echo json_encode($row);
