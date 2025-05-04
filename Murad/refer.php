<?php
include 'config.php';
$refer_type = $_POST['refer_type'];
$refer_code = $_POST['refer_code'];
$username = $_POST['username'];
if ($refer_type === 'refer') {
$entry_fee = $_POST['entry_fee'];
 if ($entry_fee === '0') {
} else {
if ($refer_code ==='false') {
} else {

$sql_update_refer = "UPDATE refers SET status = 'Claim' WHERE name = '$username' AND refer_by = '$refer_code'";
                            
                            $refer_false = "UPDATE users SET refer_by = 'false' WHERE email = '$email'";

                            if ($conn->query($sql_update_refer) === TRUE && $conn->query($refer_false) === TRUE) {
                                
                            } else {
                                echo "Error Data Insertion And Updating: " . $conn->error;
                            }
}
}
} else {

$sql_update_refer = "UPDATE refers SET status = 'Claimed' WHERE name = '$refer_code' AND refer_by = '$username'";
                            
                            $balance_sql = "UPDATE users SET balance = balance + '10', refer_earn = refer_earn + '10' WHERE username = '$username'";

                            if ($conn->query($sql_update_refer) === TRUE && $conn->query($balance_sql) === TRUE) {
                                echo "done";
                            } else {
                                echo "Error Data Insertion And Updating: " . $conn->error;
                            }
}
?>