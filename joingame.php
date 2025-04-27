<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $match_id = $_POST['match_id'];
    $fcm_key = $_POST['fcm_key'];
    $played_on = date('d-m-Y');
    include 'refer.php';
    $ffquery = "SELECT * FROM freefire WHERE id = '$match_id'";
    $ffresult = $conn->query($ffquery);

    if ($ffresult->num_rows > 0) {
        $ffrow = $ffresult->fetch_assoc();
        $player = $ffrow["total_player"];
        $joiner = $ffrow["total_joiner"];
        $match_title = $ffrow["match_title"];
        
        if ($type === 'solo') {
            $entry_fee = $ffrow["entry_fee"];
            $entry = 1;
        }
        
        if ($type === 'duo') {
            $entry_fee = $ffrow["entry_fee"] * 2;
            $entry = 2;
        }
        
        if ($type === 'squad') {
            $entry_fee = $ffrow["entry_fee"] * 4;
            $entry = 4;
        }

        if ($player > (($joiner + $entry) - 1)) {
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $balance = $row["balance"];
                $winning = $row["winning"];

                if ($balance > ($entry_fee - 1)) {
                    if ($type === 'solo') {
                        $update_sql = "UPDATE users SET balance = balance - $entry_fee, total_play = total_play + 1 WHERE email = '$email'";
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

                        $update_sql = "UPDATE users SET balance = balance - $entry_fee, total_play = total_play + 1 WHERE email = '$email'";
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

                        $update_sql = "UPDATE users SET balance = balance - $entry_fee, total_play = total_play + 1 WHERE email = '$email'";
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
                    include 'multipleff.php';
                }
            } else {
                echo "No User Found";
            }
        } else {
            echo "Match Is Full";
        }
    } else {
        echo "No Matches Found";
    }
    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>