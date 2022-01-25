<?php

session_start();
if(isset($_SESSION['id'])){
    if ($_SESSION['type'] === 'cliente')
        header('location: index.php');
    else
        header('location: dashboard.php');

}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Style -->
    <link href="src/css/style.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

    <!-- JavaScript -->
    <script src="src/js/coreui.js"></script>

    <!-- jQuery -->
    <script src="src/jquery/jquery.js"></script>
    <title>Document</title>
</head>
<body>

<h1>Home Page<br>Viva Cristo</h1>

</body>
</html>
