<?php
    require_once('php/config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>Dashboard</title>
</head>
<body>


<h1>Dashboard</h1>

<form action="logout.php">
    <input type="submit" value="Logout" class="btn btn-danger"></input>
</form>


</body>
</html>
