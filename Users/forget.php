<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row["password"];
        
        $subject = 'Recovery Password';
        $message = "Hello, Your Games Unity Password Is - $password";
        $headers = 'From: gamesunity@gmail.com' . "\r\n" .
                   'Reply-To: gamesunity@gmail.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if (mail($email, $subject, $message, $headers)) {
            echo 'We Have Sent Your Password In Your Email!';
        } else {
            echo 'Failed To Send Email.';
        }
    } else {
        echo "Please Enter Registered Email";
    }
} else {
    echo "Invalid Request Method";
}
?>