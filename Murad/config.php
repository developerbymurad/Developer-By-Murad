<?php
$hostname = "sql307.infinityfree.com";
$username = "if0_38662936";
$password = "Murad697";
$database = "if0_38662936_sk_murad";

header('Content-Type: application/json');

$conn = new mysqli($hostname, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>