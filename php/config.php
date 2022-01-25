<?php

    $username = "fliegiasetourist";
    $password = "";
    $addr = "localhost";
    $database = "my_flegiasetourist";

    $connection = new mysqli($addr, $username, $password, $database);

    if (!$connection)
        die("Sbagghiasti bestia".$connection->connect_error);

    echo '
        <!-- Style -->
        <link href="src/css/style.css" rel="stylesheet">
    
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">
    
        <!-- JavaScript -->
        <script src="src/js/coreui.js"></script>

        <!-- jQuery -->
        <script src="src/jquery/jquery.js"></script>
    ';

