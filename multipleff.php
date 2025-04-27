<?php
$total_amount = $balance + $winning;
$required_balance = $entry_fee - $balance;

if ($total_amount >= $entry_fee) {
    if ($type === 'solo') {
        $update_sql = "UPDATE users SET balance = balance - balance, winning = winning - $required_balance, total_play = total_play + 1 WHERE email = '$email'";
        $insert_sql = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name', 'freefire', '$email', '$match_id', '$fcm_key')";
        $another_sql = "UPDATE freefire SET total_joiner = total_joiner + 1 WHERE id = $match_id";
        $statistics = "INSERT INTO statistics (email, type, match_id, match_title, played_on, paid) VALUES ('$email', 'freefire', '$match_id', '$match_title', '$played_on', '$entry_fee')";

        if ($conn->query($update_sql) === TRUE && $conn->query($insert_sql) === TRUE && $conn->query($another_sql) === TRUE && $conn->query($statistics) === TRUE) {
            echo "Join Successfully";
        } else {
            echo "Error Joining: " . $conn->error;
        }
    }

    if ($type === 'duo') {
        $name2 = $_POST['name2'];

        $update_sql = "UPDATE users SET balance = balance - balance, winning = winning - $required_balance, total_play = total_play + 1 WHERE email = '$email'";
        $insert_sql = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name', 'freefire', '$email', '$match_id', '$fcm_key')";
        $insert_sql2 = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name2', 'freefire', '$email', '$match_id', '$fcm_key')";
        $another_sql = "UPDATE freefire SET total_joiner = total_joiner + 2 WHERE id = $match_id";
        $statistics = "INSERT INTO statistics (email, type, match_id, match_title, played_on, paid) VALUES ('$email', 'freefire', '$match_id', '$match_title', '$played_on', '$entry_fee')";

        if ($conn->query($update_sql) === TRUE && $conn->query($insert_sql) === TRUE && $conn->query($another_sql) === TRUE && $conn->query($insert_sql2) === TRUE && $conn->query($statistics) === TRUE) {
            echo "Join Successfully";
        } else {
            echo "Error Joining: " . $conn->error;
        }
    }

    if ($type === 'squad') {
        $name2 = $_POST['name2'];
        $name3 = $_POST['name3'];
        $name4 = $_POST['name4'];

        $update_sql = "UPDATE users SET balance = balance - balance, winning = winning - $required_balance, total_play = total_play + 1 WHERE email = '$email'";
        $insert_sql = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name', 'freefire', '$email', '$match_id', '$fcm_key')";
        $insert_sql2 = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name2', 'freefire', '$email', '$match_id', '$fcm_key')";
        $insert_sql3 = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name3', 'freefire', '$email', '$match_id', '$fcm_key')";
        $insert_sql4 = "INSERT INTO joiners (name, type, email, match_id, fcm_key) VALUES ('$name4', 'freefire', '$email', '$match_id', '$fcm_key')";
        $another_sql = "UPDATE freefire SET total_joiner = total_joiner + 4 WHERE id = $match_id";
        $statistics = "INSERT INTO statistics (email, type, match_id, match_title, played_on, paid) VALUES ('$email', 'freefire', '$match_id', '$match_title', '$played_on', '$entry_fee')";

        if ($conn->query($update_sql) === TRUE && $conn->query($insert_sql) === TRUE && $conn->query($another_sql) === TRUE && $conn->query($insert_sql2) === TRUE && $conn->query($insert_sql3) === TRUE && $conn->query($insert_sql4) === TRUE && $conn->query($statistics) === TRUE) {
            echo "Join Successfully";
        } else {
            echo "Error Joining: " . $conn->error;
        }
    }
} else {
    echo "Insufficient Balance";
}
?>