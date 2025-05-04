<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $sql = "SELECT * FROM refers WHERE refer_by = '$username'";
    $result = $conn->query($sql);

    $json_data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $json_data[] = $row;
        }

        echo json_encode($json_data);
    } else {
        echo "No Referral Found";
    }

    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>