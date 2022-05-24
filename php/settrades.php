<?php

require_once("config.php");

/** @var MySQLI $connection */

$selectedCity = $connection->real_escape_string($_GET["city"]);

// Query che seleziona tutti gli altri porti disponibili
$sql = "SELECT city FROM harbors WHERE city != '$selectedCity'";

$retArr = [];

if ($result = $connection->query($sql)) {
    while ($cities = $result->fetch_array(MYSQLI_ASSOC)) {
        if ($cities['city'] != $_GET['city']) {
            $retArr[] = $cities['city'];
        }

    }

    // Query che seleziona porti già relazionati con quello di partenza selezionato
    $sql = "SELECT * FROM trades WHERE harb_dep = '$selectedCity' OR harb_arr = '$selectedCity'";

    if ($resultFilter = $connection->query($sql)) {
        while ($resRow = $resultFilter->fetch_array(MYSQLI_ASSOC)) {
            if (in_array($resRow['harb_dep'], $retArr) && $resRow['deleted'] != 1) {
                $pos = array_search($resRow['harb_dep'], $retArr);
                unset($retArr[$pos]);
            }
            if (in_array($resRow['harb_arr'], $retArr) && $resRow['deleted'] != 1) {
                $pos = array_search($resRow['harb_arr'], $retArr);
                unset($retArr[$pos]);
            }
        }
    } else {
        echo "Errore";
    }

} else {
    echo "Errore";
}

$retArr = array_values($retArr);

echo json_encode($retArr);