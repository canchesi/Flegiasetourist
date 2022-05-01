<?php

    session_start();
    /**@var MYSQLI $connection*/
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
        header("location: login.php");
        exit;
    }

    require_once('config.php');

    $id = $connection->real_escape_string($_GET['id']); //ID rotta

    //Query che controlla se la rotta è partita
    $sql = "SELECT dep_eff FROM routes WHERE id = '" . $id . "'";
    if($result = $connection->query($sql))
        if($row = $result->fetch_array(MYSQLI_ASSOC))
            // Se non è partita restituisce false e termina
            if($row['dep_eff']) {
                echo false;
                exit();
            }
    // Query che cambia il flag della rotta annullata
    $sql = "UPDATE routes SET deleted = '1' WHERE id = '".$id."'";

    echo true;

    if ($connection->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        die();
    }

    $connection->close();
