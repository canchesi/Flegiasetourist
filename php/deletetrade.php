<?php

    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
        header("location: login.php");
        exit;
    }

    require_once('config.php');

    $id = explode("-", $connection->real_escape_string($_GET['id']));

    $sql = "DELETE FROM trades WHERE harb_dep ='" . $id[0] . "' AND harb_arr = '" . $id[1] . "'";


    if ($connection->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        die();
    }

    $connection->close();
