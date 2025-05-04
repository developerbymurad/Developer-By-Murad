<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'getdata') {
        $sql = "SELECT * FROM upload";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $json_data = json_encode($rows);
            echo $json_data;
        } else {
            echo "No Data Found";
        }
    }

    if ($type === 'upload') {
        $email = $_POST['email'];
        $game_name = $_POST['game_name'];
        $match_title = $_POST['match_title'];
        $total_prize = $_POST['total_prize'];
        $image_url = $_POST['image_url'];
        $match_id = $_POST['match_id'];

        $sql = "SELECT * FROM upload WHERE email='$email' AND match_id='$match_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "You Have Already Uploaded";
        } else {
            $sql = "INSERT INTO upload (email, game_name, match_title, total_prize, image_url, match_id) VALUES ('$email', '$game_name', '$match_title', '$total_prize', '$image_url', '$match_id')";
            if ($conn->query($sql) === TRUE) {
                echo "Image Uploaded Successfully";
            } else {
                echo "Error Uploading Image: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    
    if ($type === 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM upload WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Image Deleted Successfully";
        } else {
            echo "Error Deleting Image: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>