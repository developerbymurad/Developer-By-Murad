<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "Demo";

header('Content-Type: application/json');

$conn = new mysqli($hostname, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>