<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'getdata') {
        $id = $_POST['id'];
        $match_type = $_POST['match_type'];
        
        $query = "SELECT * FROM joiners WHERE type = '$match_type' AND match_id = '$id'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            if (!empty($data)) {
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo "No Joiner Found";
            }
        } else {
            echo "Error Getting Joiner: " . mysqli_error($conn);
        }
    }
    
    if ($type === 'statistics') {
        $email = $_POST['email'];
    
        $query = "SELECT * FROM statistics WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            if (!empty($data)) {
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo "No Statistics Found";
            }
        } else {
            echo "Error Getting Statistics: " . mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
} else {
    echo "Invalid Request Method";
}
?>