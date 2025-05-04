<?php
include 'config.php';

$logFile = 'ip_log.json';

$ipAddress = $_SERVER['REMOTE_ADDR'];

$currentTime = time();

if (file_exists($logFile)) {
    $ipLog = json_decode(file_get_contents($logFile), true);
} else {
    $ipLog = [];
}

if (isset($ipLog[$ipAddress])) {
    $lastRequestTime = $ipLog[$ipAddress];
    if (($currentTime - $lastRequestTime) < 3600) {
        http_response_code(429);
        die("You Can Only One SignUp Per Hour.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $password = $_POST["password"];
    $balance = 0;
    $device_id = $_POST["device_id"];
    $fcm_key = $_POST["fcm_key"];
    $refer_code = $_POST["refer_code"];
    $date = new DateTime();
    $newDate = $date->format("d-M-Y");
    
    $sql_device_check = "SELECT * FROM users WHERE device_id = '$device_id'";
    $result_device_check = $conn->query($sql_device_check);
    if ($result_device_check->num_rows > 0) {
        echo "Device Is Already Registered";
    } else {
        $sql_username_check = "SELECT * FROM users WHERE username = '$username'";
        $result_username_check = $conn->query($sql_username_check);
        
        if ($result_username_check->num_rows > 0) {
            echo "Username Already Exists";
        } else {
            $sql_email_check = "SELECT * FROM users WHERE email = '$email'";
            $result_email_check = $conn->query($sql_email_check);
            
            if ($result_email_check->num_rows > 0) {
                echo "Email Is Already Registered";
            } else {
                $sql_number_check = "SELECT * FROM users WHERE number = '$number'";
                $result_number_check = $conn->query($sql_number_check);
                
                if ($result_number_check->num_rows > 0) {
                    echo "Number Is Already Registered";
                } else {
                    if (empty($refer_code)) {
                        $sql_insert_data = "INSERT INTO users (first_name, last_name, username, email, number, password, balance, fcm_key, device_id, refer_by) VALUES ('$first_name', '$last_name', '$username', '$email', '$number', '$password', '$balance', '$fcm_key', '$device_id', 'false')";
                        
                        if ($conn->query($sql_insert_data) === TRUE) {
                            echo "Data Insertion Success";
                            
                            $ipLog[$ipAddress] = $currentTime;
                            
                            file_put_contents($logFile, json_encode($ipLog));
                        } else {
                            echo "Error Inserting Data: " . $conn->error;
                        }
                    } else {
                        $sql_refer_code_check = "SELECT * FROM users WHERE username = '$refer_code'";
                        $result_refer_code_check = $conn->query($sql_refer_code_check);
                
                        if ($result_refer_code_check->num_rows > 0) {
                            $sql_insert_data = "INSERT INTO users (first_name, last_name, username, email, number, password, balance, fcm_key, device_id, refer_by) VALUES ('$first_name', '$last_name', '$username', '$email', '$number', '$password', '5', '$fcm_key', '$device_id', '$refer_code')";
                            $sql_update_balance = "UPDATE users SET total_refer = total_refer + '1' WHERE username = '$refer_code'";
                            $sql_insert_refers = "INSERT INTO refers (date, name, status, refer_by) VALUES ('$newDate', '$username', 'Registered', '$refer_code')";

                            if ($conn->query($sql_insert_data) === TRUE && $conn->query($sql_update_balance) === TRUE && $conn->query($sql_insert_refers) === TRUE) {
                                echo "Data Insertion And Update Success";
                                
                                $ipLog[$ipAddress] = $currentTime;
                                
                                file_put_contents($logFile, json_encode($ipLog));
                            } else {
                                echo "Error Data Insertion And Updating: " . $conn->error;
                            }
                        } else { 
                            echo "Invalid Promo Code";
                        }
                    }
                }
            }
        }
    }
    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>