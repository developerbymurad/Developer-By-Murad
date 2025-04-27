<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $method = $_POST["method"];
    $trxid = $_POST["trxid"];
    date_default_timezone_set('Asia/Dhaka');
    $date = date("d-M-Y");
    $time = date("h:i:s A");

    $stmt = $conn->prepare("SELECT amount, sender, status FROM transaction WHERE trxid = ? AND gateway = ?");
    $stmt->bind_param("ss", $trxid, $method);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $amount = $row["amount"];
        $sender = $row["sender"];
        $status = intval($row["status"]);

        if ($status === 0) {
            $conn->begin_transaction();
            try {
                $update = $conn->prepare("UPDATE transaction SET status = 1 WHERE trxid = ?");
                $update->bind_param("s", $trxid);
                $update->execute();

                $sql = $conn->prepare("INSERT INTO addmoney (name, email, method, number, amount, trxid, status, date, time) VALUES (?, ?, ?, ?, ?, ?, 'Success', ?, ?)");
                $sql->bind_param("ssssssss", $name, $email, $method, $sender, $amount, $trxid, $date, $time);
                $sql->execute();

                $update2 = $conn->prepare("UPDATE users SET balance = balance + ? WHERE email = ?");
                $update2->bind_param("ds", $amount, $email);
                $update2->execute();

                $conn->commit();
                echo "Add Money Success";
            } catch (Exception $e) {
                $conn->rollback();
                echo "Add Money Failed";
            }
        } else {
            echo "Transaction ID Already Used";
        }
    } else {
        echo "Invalid Transaction ID";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>