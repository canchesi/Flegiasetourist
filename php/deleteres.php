<?php
    /** @var MYSQLI $connection*/
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'cliente') {
        header("location: login.php");
        exit();
    }

    require_once('config.php');


    $idRes = $_GET['idres'];
    $numPass = 0;

    $sql = "SELECT adults, underages, route_id FROM reservations WHERE code = '$idRes'";
    if($result = $connection->query($sql)){
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $numPass = $row['adults'] + $row['underages'];

            $sql = "
                    UPDATE routes SET num_pass = num_pass - '".$numPass."' WHERE id = '".$row['route_id']."';
                    UPDATE reservations SET undone = '1' WHERE code = '".$idRes."';
            ";


            if($result = $connection->multi_query($sql))
                echo '0';
            else
                echo '-1';
        }

    }

$connection->close();
