<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid Request Method";
    die();
}

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$method = $_POST['method'] ?? null;
$number = $_POST['number'] ?? null;
$amount = $_POST['amount'] ?? null;
$trxid = $_POST['trxid'] ?? null;
$fcm = $_POST['fcm'] ?? null;
$date = date("d-M-Y");
$time = date("h:i:s A");

$email = mysqli_real_escape_string($conn, $email);

if (!$email || !$method || !$number || !$amount || !$trxid) {
    echo "Missing Fields";
    die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email Address";
    die();
}

if (!preg_match('/^[a-zA-Z0-9]{8,15}$/', $trxid)) {
    echo "Invalid Transaction ID";
    die();
}

if ($amount < 100) {
    echo "Minimum Withdraw Amount Is 100 TK";
    die();
}

$user_query = "SELECT winning FROM users WHERE email = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows === 0) {
    echo "No User Found";
    die();
}

$user = $user_result->fetch_assoc();
$winning = $user["winning"];

if ($winning < $amount) {
    echo "Insufficient Balance";
    die();
}

$insert_query = "INSERT INTO withdraw (name, email, method, number, amount, trxid, date, time, fcm) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("sssssssss", $name, $email, $method, $number, $amount, $trxid, $date, $time, $fcm);

$update_balance_query = "UPDATE users SET winning = winning - ? WHERE email = ?";
$stmt2 = $conn->prepare($update_balance_query);
$stmt2->bind_param("is", $amount, $email);

if ($stmt->execute() && $stmt2->execute()) {
    echo "Request Successfully";
} else {
    echo "Error Processing Request";
}

$stmt->close();
$conn->close();
?>