<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fcm_key = $_POST['fcm_key'];
    $device_id = $_POST['device_id'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $device = "SELECT * FROM users WHERE device_id = '$device_id'";
        $query = $conn->query($device);

        if ($query->num_rows > 0) {
            $update = "UPDATE users SET fcm_key = '$fcm_key' WHERE email = '$email'";
            
            if ($conn->query($update) === TRUE) {
                echo "Login Success";
            } else {
                echo "Login Cancelled";
            }
        } else {
            echo "Please Login Own Device";
        }
    } else {
        echo "Wrong Email Or Password";
    }
    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>