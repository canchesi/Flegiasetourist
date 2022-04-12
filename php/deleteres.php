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

    $sql = "SELECT adults, underages, ship_id, dep_exp FROM reservations WHERE code = '$idRes'";
    if($result = $connection->query($sql)){
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $numPass = $row['adults'] + $row['underages'];
            $shipID = $row['ship_id'];
            $depExp = $row['dep_exp'];

            $sql = "
                    UPDATE routes SET num_pass = num_pass - $numPass WHERE ship_id = '$shipID' AND dep_exp = '$depExp';
                    UPDATE reservations SET undone = '1' WHERE code = '$idRes';
            ";

            if($result = $connection->multi_query($sql))
                echo '0';
            else
                echo '-1';
        }

    }

$connection->close();
