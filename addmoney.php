<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['type']) || trim($_POST['type']) !== 'requestxstrong') {
        echo json_encode(["error" => "Invalid request"]);
        exit;
    }

    $name   = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email  = isset($_POST['email']) ? trim($_POST['email']) : '';
    $method = isset($_POST['method']) ? trim($_POST['method']) : '';
    $number = isset($_POST['number']) ? trim($_POST['number']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $trxid  = isset($_POST['trxid']) ? trim($_POST['trxid']) : '';
    $fcm    = isset($_POST['fcm']) ? trim($_POST['fcm']) : '';

    if (empty($name) || empty($email) || empty($method) || empty($number) || empty($amount) || empty($trxid) || empty($fcm)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    $date = date("d-M-Y");
    $time = date("h:i:s A");

    $sql = "INSERT INTO addmoney (name, email, method, number, amount, trxid, date, time, fcm) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $email, $method, $number, $amount, $trxid, $date, $time, $fcm);

    if ($stmt->execute()) {
        echo "Request Successfully";
    } else {
        echo json_encode(["error" => "Error Requesting: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid Request Method"]);
}
?>