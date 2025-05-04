<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST["table"];
    $email = $_POST["email"];

    $sql = "SELECT * FROM $table WHERE email = '$email'";
    $result = $conn->query($sql);

    $json_data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $json_data[] = $row;
        }

        echo json_encode($json_data);
    } else {
        echo "No Data Found";
    }

    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>