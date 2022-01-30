<?php

    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
        header("location: login.php");
        exit;
    }

    require_once('config.php');

    $id = explode("-", $connection->real_escape_string($_GET['id']), 2);

    $sql = "DELETE FROM routes WHERE ship_id ='" . $id[0] . "' AND dep_exp = '" . $id[1] . "'";


    if ($connection->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        die();
    }

    $connection->close();
