<?php
$localhost = "127.0.0.1"; // or "localhost"
$root = "root"; // MySQL username
$Enya_system = "Enya_system"; // Replace with your MySQL password, or leave empty if none
$bj_klins = "bj_klins"; // Your database name

$connection = new mysqli($localhost, $root, $Enya_system, $bj_klins);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
