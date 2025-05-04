<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
        echo json_encode(["error" => "Email is required"]);
        exit;
    }

    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $email = trim($_POST['email']);

    if ($type === 'one') {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode($result->fetch_assoc());
        } else {
            echo json_encode(["error" => "No User Found"]);
        }

        $stmt->close();
    }

    if ($type === 'edit') {
        if (!isset($_POST['first_name'], $_POST['last_name'], $_POST['number'])) {
            echo json_encode(["error" => "All fields are required"]);
            exit;
        }

        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $number = trim($_POST['number']);

        $sql = "UPDATE users SET first_name = ?, last_name = ?, number = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $number, $email);

        if ($stmt->execute()) {
            echo "Profile Updated Successfully";
        } else {
            echo json_encode(["error" => "Error Updating Profile"]);
        }

        $stmt->close();
    }

    if ($type === 'pass') {
        if (!isset($_POST['oldpass'], $_POST['newpass'])) {
            echo json_encode(["error" => "Old and new passwords are required"]);
            exit;
        }

        $oldpass = trim($_POST['oldpass']);
        $newpass = trim($_POST['newpass']);

        $query = "SELECT password FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (!password_verify($oldpass, $user['password'])) {
                echo json_encode(["error" => "Old Password Is Incorrect!"]);
                exit;
            }

            $hashed_newpass = password_hash($newpass, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_newpass, $email);

            if ($stmt->execute()) {
                echo "Password Changed Successfully";
            } else {
                echo json_encode(["error" => "Error Changing Password"]);
            }

            $stmt->close();
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid Request Method"]);
}
?>