<?php

    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
        header("location: login.php");
        exit;
    }

    require_once('config.php');

    /** @var MYSQLI $connection*/

    $id = explode("-", $connection->real_escape_string($_GET['id'])); // Vettore i due campi che identificano la tratta

    // Query che aggiorna il flag della tratta eliminata
    $sql = "UPDATE trades SET deleted = 1 WHERE harb_dep ='" . $id[0] . "' AND harb_arr = '" . $id[1] . "'";

    if ($connection->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        die();
    }

    $connection->close();
