<?php
$hostname = "sql301.infinityfree.com";
$username = "if0_38654605";
$password = "SkMuradBoss69";
$database = "if0_38654605";

header('Content-Type: application/json');

$conn = new mysqli($hostname, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
