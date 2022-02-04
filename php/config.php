<?php

    $username = "fliegiasetourist";
    $password = "";
    $addr = "localhost";
    $database = "my_flegiasetourist";

    $connection = new mysqli($addr, $username, $password, $database);

    if (!$connection)
        die("Errore di connessione: ".$connection->connect_error);

    session_start();

    $del = "SELECT deleted FROM users WHERE id_code = " . $_SESSION['id'];
    if($result = $connection->query($del))
        if($row = $result->fetch_array())
            if($row['deleted'])
                header('location: ../logout.php');