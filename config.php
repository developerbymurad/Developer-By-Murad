<?php
$hostname = "localhost";
$username = "appktop_developerbymurad";
$password = "appktop_developerbymurad";
$database = "appktop_developerbymurad";

header('Content-Type: application/json');

$conn = new mysqli($hostname, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
