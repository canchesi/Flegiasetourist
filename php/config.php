<?php

    $username = "fliegiasetourist";
    $password = "";
    $addr = "localhost";
    $database = "my_flegiasetourist";

    $connection = new mysqli($addr, $username, $password, $database);

    if (!$connection)
        die("Errore di connessione: ".$connection->connect_error);

