<?php

session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
    header("location: login.php");
    exit;
}

require_once('config.php');

$id = $connection->real_escape_string($_GET['id']);

$sql = "DELETE FROM users WHERE user_id = $id ";


if ($connection->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $connection->error;
    die();
}

$connection->close();
